<?php

namespace App\EntityListener;

use App\Entity\Gig;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class GigEntityListener
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function prePersist(Gig $gig, LifecycleEventArgs $event)
    {
        $gig->computeSlug($this->slugger);
    }

    public function preUpdate(Gig $gig, LifecycleEventArgs $event)
    {
        $gig->computeSlug($this->slugger);
    }
}