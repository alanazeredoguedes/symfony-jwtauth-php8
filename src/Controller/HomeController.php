<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'home_')]
class HomeController extends AbstractController
{

    #[Route('/', name: 'redirect_admin')]
    public function redirectAdmin(): Response
    {
        return $this->redirectToRoute('sonata_admin_dashboard');
    }

    #[Route('/api/teste', name: 'api_teste')]
    public function teste(): Response
    {
        return $this->json([
            'message' => 'Api Teste',
            'path' => 'src/Controller/ApiTesteController.php',
        ]);
    }


}