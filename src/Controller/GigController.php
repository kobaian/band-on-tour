<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GigController extends AbstractController
{
    #[Route('hello/{name}', name: 'gig')]
    public function index(string $name): Response
    {
        $greet = '';
        if ($name) {
            $greet = sprintf('<h1>Hello %s!</h1>', htmlspecialchars($name));
        }

        return new Response(<<<EOF
 <html>
     <body>
    $greet
         <img src="/images/website-under-construction.gif" />
     </body>
 </html>
 EOF);
//        return $this->render('gig/index.html.twig', [
//            'controller_name' => 'GigController',
//        ]);
    }
}
