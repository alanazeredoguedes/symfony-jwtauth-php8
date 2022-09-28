<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/api', name: 'api_')]
class ApiTesteController extends AbstractController
{

    #[Route('/teste', name: 'api_teste')]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Api Teste',
            'path' => 'src/Controller/ApiTesteController.php',
        ]);
    }
}