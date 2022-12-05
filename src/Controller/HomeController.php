<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
  
  #[Route('/home/about', name: 'home.about', methods: ['GET'])]
    public function about(): Response
    {
               return $this->render('home/about.html.twig');
    }


}
