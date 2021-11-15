<?php

namespace App\Factory;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Twig\Environment;

class HomepageFactory implements HomepageFactoryInterface
{
    /**
     * @var \Twig\Environment
     */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function create(?UserInterface $user): Response
    {
        return $this->provideTemplate($user);
    }

    private function provideTemplate(?UserInterface $user): Response
    {
        if ($user === null) {
            return new Response($this->twig->render('homepage/guest.html.twig', []));
        }
        switch ($user->getType()) {
            case User::BAND_USER:
                return new Response($this->twig->render('homepage/band.html.twig', []));
            case User::PROMOTER_USER:
                return new Response($this->twig->render('homepage/promoter.html.twig', []));
            case User::FAN_USER:
                return new Response($this->twig->render('homepage/fan.html.twig', []));
            default:
                return new Response($this->twig->render('homepage/guest.html.twig', []));
        }
    }
}