<?php

namespace App\Controller;

use App\Entity\Gig;
use App\Repository\CommentRepository;
use App\Repository\GigRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    #[Route('/', name: 'gigs')]
    public function index(GigRepository $gigRepository): Response
    {
        return new Response($this->twig->render('gig/index.html.twig', [
                'gigs' => $gigRepository->findAll(),
            ]
        ));
    }

    #[Route('/gig/{id}', name: 'gig')]
    public function show(Request $request, Gig $gig, CommentRepository $commentRepository)
    {
        $offset = max(0, $request->query->getInt('offset'));
        $paginator = $commentRepository->getCommentPaginator($gig, $offset);

        return new Response($this->twig->render('gig/show.html.twig', [
                'gig' => $gig,
                'comments' => $paginator,
                'previous' => $offset - CommentRepository::PAGINATOR_PER_PAGE,
                'next' => min(count($paginator), $offset + CommentRepository::PAGINATOR_PER_PAGE),
            ]
        ));
    }
}
