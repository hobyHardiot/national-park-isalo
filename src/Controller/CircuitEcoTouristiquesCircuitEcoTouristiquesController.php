<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CircuitEcoTouristiquesCircuitEcoTouristiquesController extends AbstractController
{
    #[Route('/circuit', name: 'app_circuit')]
    public function index(): Response
    {
        return $this->render('circuit_eco_touristiques_circuit_eco_touristiques/index.html.twig', [
            'controller_name' => 'CircuitEcoTouristiquesCircuitEcoTouristiquesController',
        ]);
    }
    #[Route('/circuit/piscine', name: 'app_circuit_piscine')]
    public function piscine(): Response
    {
        return $this->render('circuit_eco_touristiques_circuit_eco_touristiques/piscine-naturel.twig', [
            'controller_name' => 'CircuitEcoTouristiquesCircuitEcoTouristiquesController',
        ]);
    }
}
