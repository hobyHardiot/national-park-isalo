<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SpecificiteController extends AbstractController
{
    #[Route('/faune', name: 'app_faune')]
    public function index(): Response
    {
        return $this->render('specificite/faune.html.twig', [
            'controller_name' => 'SpecificiteController',
        ]);
    }
    #[Route('/flore', name: 'app_flore')]
    public function flore(): Response
    {
        return $this->render('specificite/flore.html.twig', [
            'controller_name' => 'SpecificiteController',
        ]);
    }
    #[Route('/paysage', name: 'app_paysage')]
    public function paysage(): Response
    {
        return $this->render('specificite/paysage.html.twig', [
            'controller_name' => 'SpecificiteController',
        ]);
    }
}
