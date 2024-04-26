<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Request; 
use PhpOffice\PhpWord\IOFactory; 
use PhpOffice\PhpWord\PhpWord;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Writer\HTML;
use PhpOffice\PhpWord\Settings;


class HebergementController extends AbstractController
{
    #[Route('/hebergement', name: 'app_hebergement')]
    public function index(): Response
    {
        return $this->render('hebergement/index.html.twig', [
            'controller_name' => 'HebergementController',
        ]);
    }
    #[Route('/hebergement/checkout', name: 'app_checkout')]
    public function checkout($stripeSK): Response
    { 
        try {
            Stripe::setApiKey($stripeSK);

            $totalPrice = floatval($_POST['totalPrice']); 
            $selectLabel = $_POST['selectLabel']; 
            $paymentLabel = $_POST['paymentLabel']; 

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items'           => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data'=>[
                            'name' => $selectLabel,
                            'description' => $paymentLabel,
                            'images' => ['https://dynamic-media-cdn.tripadvisor.com/media/photo-o/26/af/ac/67/isalo-rock-lodge.jpg?w=700&h=-1&s=1'],
                        ],
                        'unit_amount' =>  $totalPrice * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => $this->generateUrl('success_url', [
                    'totalPrice' => $totalPrice,
                    'selectLabel' => $selectLabel,
                    'paymentLabel' => $paymentLabel
                ], UrlGeneratorInterface::ABSOLUTE_URL), 
                'cancel_url'  => $this->generateUrl('cancel_url',[],UrlGeneratorInterface::ABSOLUTE_URL),
            ]);
            
            return $this->redirect($session->url, 303);
        } catch (ApiConnectionException $e) {
            // Log the exception or handle it as needed
            // For example, return a simple HTML response
            return new Response('<p>Error</p>', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    #[Route('/hebergement/success-url', name: 'success_url')]
    public function successUrl(Request $request): Response
    {
        $totalPrice = $request->query->get('totalPrice');
        $selectLabel = $request->query->get('selectLabel');
        $paymentLabel = $request->query->get('paymentLabel');
    
        return $this->render('hebergement/payement/success.html.twig', [
            'totalPrice' => $totalPrice,
            'selectLabel' => $selectLabel,
            'paymentLabel' => $paymentLabel
        ]);
    }
    
    #[Route('/hebergement/cancel-url', name: 'cancel_url')]
    public function cancelUrl(): Response
    {
        return $this->render('hebergement/payement/cancel.html.twig', []);
    }

    #[Route('/hebergement/pdf', name: 'pdf')]
    public function pdf(): Response
    {
        return $this->render('hebergement/payement/cancel.html.twig', []);
    }

    #[Route('/hebergement/recu', name: 'generer_recu')]
    public function recu(Request $request): Response
    {  

        $totalPrice = $request->query->get('totalPrice');
        $selectLabel = $request->query->get('selectLabel');
        $paymentLabel = $request->query->get('paymentLabel');
        $dompdf = new Dompdf();
        $html = $this->renderView('hebergement/payement/pdf.html.twig', [
            'totalPrice' => $totalPrice,
            'selectLabel' => $selectLabel,
            'paymentLabel' => $paymentLabel
        ]);
        $dompdf->loadHtml($html);
 

        $dompdf->render();
 
        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}