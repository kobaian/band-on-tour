<?php

namespace App\Controller;

use App\Factory\HomepageFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(HomepageFactory $homepageFactory): Response
    {
        return $homepageFactory->create($this->getUser());
    }
}
