<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route; 
use Symfony\Component\HttpFoundation\Request;


class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/default', name: 'app_default')]
    public function default(): Response
    {
        return $this->render('home/default.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/lang/{locale}', name: 'change_locale')]
    public function changeLocale($locale, Request $request): Response
    {
        $request->getSession()->set('_locale',$locale);
         
        return $this->redirect($request->headers->get('referer'));
    }


}
