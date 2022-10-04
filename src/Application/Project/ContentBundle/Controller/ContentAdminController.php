<?php

namespace App\Application\Project\ContentBundle\Controller;

use App\Application\Project\ContentBundle\Attributes\ARR;
use App\Application\Project\ContentBundle\Controller\DefaultCRUDController;
use App\Application\Project\ContentBundle\Service\RolesIdentifierService;
use ReflectionException;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ContentAdminController extends DefaultCRUDController
{

//    #[ARR(routerName: 'listAction', role: "ROLE_ADMIN_GROUP_LIST", title: 'Listar', description: 'Lista todos os grupos')]
//    protected string $listAction = "ROLE_ADMIN_GROUP_LIST";
//
//    #[ARR(routerName: 'showAction', role: "ROLE_ADMIN_GROUP_SHOW", title: 'Visualizar')]
//    protected string $showAction = "ROLE_ADMIN_GROUP_SHOW";
//
//    #[ARR(routerName: 'createAction', role: "ROLE_ADMIN_GROUP_CREATE", title: 'Criar')]
//    protected string $createAction = "ROLE_ADMIN_GROUP_CREATE";
//
//    #[ARR(routerName: 'editAction', role: "ROLE_ADMIN_GROUP_EDIT", title: 'Editar')]
//    protected string $editAction  = "";
//
//    #[ARR(routerName: 'deleteAction', role: "ROLE_ADMIN_GROUP_DELETE", title: 'Excluir')]
//    protected string $deleteAction = "ROLE_ADMIN_GROUP_DELETE";
//
//    #[ARR(routerName: 'batchAction', role: "ROLE_ADMIN_GROUP_BATCH", title: 'Excluir em Lote')]
//    protected string $batchAction = "ROLE_ADMIN_GROUP_BATCH";
//
//    #[ARR(routerName: 'exportAction', role: "ROLE_ADMIN_GROUP_EXPORT", title: 'Exportar')]
//    protected string $exportAction = "ROLE_ADMIN_GROUP_EXPORT";
//
//    #[ARR(routerName: 'historyAction', role: "ROLE_ADMIN_GROUP_HISTORY", title: 'Auditoria')]
//    protected string $historyAction = "ROLE_ADMIN_GROUP_AUDIT";


    /**
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function loginAction(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('@ApplicationProjectUser/auth/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    public function logoutAction(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /** @return Response */
    public function accessDeniedAction(): Response
    {
        return $this->render('@ApplicationProjectContent/error/error_403.html.twig');
    }


}