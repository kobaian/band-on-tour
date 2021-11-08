<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Gig;
use App\Form\CommentFormType;
use App\Repository\CommentRepository;
use App\Repository\GigRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

    public function __construct(Environment $twig, EntityManagerInterface $entityManager)
    {
        $this->twig = $twig;
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'gigs')]
    public function index(GigRepository $gigRepository): Response
    {
        return new Response($this->twig->render('gig/index.html.twig', [
                'gigs' => $gigRepository->findAll(),
            ]
        ));
    }

    #[Route('/gig/{slug}', name: 'gig')]
    public function show(Request $request, Gig $gig, CommentRepository $commentRepository, string $photoDir)
    {
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
