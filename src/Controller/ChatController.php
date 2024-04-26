<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class ChatController extends AbstractController
{
    private $httpClient;
    private $openaiApiKey;

    public function __construct(HttpClientInterface $httpClient, string $openaiApiKey)
    {
        $this->httpClient = $httpClient;
        $this->openaiApiKey = $openaiApiKey;
    }

    #[Route('/chatbot', name: 'chatbot')]
    public function chatbot(): Response
    {
        $content = $this->renderView('chat/index.html.twig');
        return new Response($content);
    }

    #[Route('/api/chat', name: 'api_chat', methods: ['POST'])]
    public function chat(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $userMessage = $data['message'];

        $response = $this->httpClient->request('POST', 'https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->openaiApiKey
            ],
            'json' => [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'user', 'content' => $userMessage]
                ]
            ]
        ]);

        $responseData = $response->toArray();
        $chatbotResponse = $responseData['choices'][0]['message']['content'];

        return new JsonResponse(['response' => $chatbotResponse]);
    }
}