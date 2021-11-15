<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Gig;
use App\Form\CommentFormType;
use App\Message\CommentMessage;
use App\Repository\CommentRepository;
use App\Repository\GigRepository;
use App\SpamChecker;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class GigController extends AbstractController
{
    /**
     * @var \Twig\Environment
     */
    private $twig;

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var \Symfony\Component\Messenger\MessageBusInterface
     */
    private $bus;

    public function __construct(Environment $twig, EntityManagerInterface $entityManager, MessageBusInterface $bus)
    {
        $this->twig = $twig;
        $this->entityManager = $entityManager;
        $this->bus = $bus;
    }

    #[Route('gigs/', name: 'gigs')]
    public function index(GigRepository $gigRepository): Response
    {
        return new Response($this->twig->render('gig/index.html.twig', [
                'gigs' => $gigRepository->findAll(),
            ]
        ));
    }

    #[Route('/gig/{slug}', name: 'gig')]
    public function show(
        Request $request,
        Gig $gig,
        CommentRepository $commentRepository,
        SpamChecker $spamChecker,
        string $photoDir
    ) {
        $offset = max(0, $request->query->getInt('offset'));
        $paginator = $commentRepository->getCommentPaginator($gig, $offset);

        $comment = new Comment();
        $commentFrom = $this->createForm(CommentFormType::class, $comment);
        $commentFrom->handleRequest($request);
        if ($commentFrom->isSubmitted() && $commentFrom->isValid()) {
            $comment->setGig($gig);

            if ($photo = $commentFrom['photo']->getData()) {
                $filename = bin2hex(random_bytes(6)) . '.' . $photo->guessExtension();
                try {
                    $photo->move($photoDir, $filename);
                } catch (FileException $e) {
                    // unable to upload the photo, give up
                }
                $comment->setPhotoFilename($filename);
            }

            $this->entityManager->persist($comment);
            $this->entityManager->flush();

            $context = [
                'user_ip' => $request->getClientIp(),
                'user_agent' => $request->headers->get('user-agent'),
                'referrer' => $request->headers->get('referer'),
                'permalink' => $request->getUri(),
            ];

            $this->bus->dispatch(new CommentMessage($comment->getId(), $context));

            return $this->redirectToRoute('gig', ['slug' => $gig->getSlug()]);
        }

        return new Response($this->twig->render('gig/show.html.twig', [
                'gig' => $gig,
                'comments' => $paginator,
                'previous' => $offset - CommentRepository::PAGINATOR_PER_PAGE,
                'next' => min(count($paginator), $offset + CommentRepository::PAGINATOR_PER_PAGE),
                'comment_form' => $commentFrom->createView(),
            ]
        ));
    }
}
