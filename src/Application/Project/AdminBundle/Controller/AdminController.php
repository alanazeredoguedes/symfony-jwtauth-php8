<?php

namespace App\Application\Project\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'admin_')]
class AdminController extends AbstractController
{

    #[Route('/juca', name: 'api_dsad')]
    public function teste(): Response
    {

        #return $this->render('@ApplicationProjectAdmin/templates/standard_layout.html.twig')
        return $this->json([
            'message' => 'Admin Teste',
            'path' => 'src/Controller/ApiTesteController.php',
        ]);
    }


}