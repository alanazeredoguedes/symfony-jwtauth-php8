<?php

namespace App\Application\Project\ContentBundle\Controller;

use App\Application\Project\ContentBundle\Attributes\ARR;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultCRUDController extends CRUDController
{

    /**
     * Validate access as routes
     * @param string $role
     * @return void
     */
    public function validateAccess(string $role): void
    {
        if($this->isGranted("ROLE_SUPER_ADMIN"))
            return;

        if($role)
            $this->denyAccessUnlessGranted($role);
    }

}