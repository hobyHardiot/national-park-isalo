<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/project01', name: 'app_contact')]
    public function index(): Response
    {
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }
    #[Route('/project02', name: 'app_p')]
    public function projet2(): Response
    {
        return $this->render('contact/project02.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }
    #[Route('/carousel', name: 'app_carousel')]
    public function carousel(): Response
    {
        return $this->render('contact/carousel.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }
}
