<?php

namespace App\Application\Project\UserBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class GroupAdminController extends CRUDController
{

    public function createAction(Request $request): Response
    {
        return parent::createAction($request);
    }

    public function editAction(Request $request): Response
    {



        return parent::editAction($request);
    }

    public function listAction(Request $request): Response
    {

        return parent::listAction($request);
    }
}