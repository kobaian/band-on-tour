<?php

namespace App\EventSubscriber;

use App\Repository\GigRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Twig\Environment;

class TwigEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Twig\Environment
     */
    private $twig;

    /**
     * @var \App\Repository\GigRepository
     */
    private $gigRepository;

    public function __construct(Environment $twig, GigRepository $gigRepository)
    {
        $this->twig = $twig;
        $this->gigRepository = $gigRepository;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $this->twig->addGlobal('gigs', $this->gigRepository->findAll());
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.controller' => 'onKernelController',
        ];
    }
}
