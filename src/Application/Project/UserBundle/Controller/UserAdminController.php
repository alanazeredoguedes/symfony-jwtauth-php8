<?php

namespace App\Application\Project\UserBundle\Controller;
use App\Application\Project\AdminBundle\Controller\CRUDBaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserAdminController extends CRUDBaseController
{

    public function loginAction(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('@ApplicationProjectUser/auth/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
        //return new Response('Login Admin');
    }

    public function logoutAction(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

}