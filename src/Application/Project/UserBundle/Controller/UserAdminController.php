<?php

namespace App\Application\Project\UserBundle\Controller;
use App\Application\Project\AdminBundle\Attributes\AuthRouterRegister;
use App\Application\Project\AdminBundle\Controller\CRUDBaseController;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[AuthRouterRegister(groupName: 'Usuario', description: 'Permissões do modulo de Usuario')]
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

    ##[IsGranted(data: "ROLE_ADMIN_USER_LIST")]
    #[AuthRouterRegister(routerName: 'Listar', role: "ROLE_ADMIN_USER_LIST", description: '...')]
    public function listAction(Request $request): Response
    {
        return parent::listAction($request);
    }

    ##[IsGranted("ROLE_ADMIN_USER_SHOW")]
    #[AuthRouterRegister(routerName: 'Visualizar', role: "ROLE_ADMIN_USER_SHOW", description: '...')]
    public function showAction(Request $request): Response
    {
        return parent::showAction($request);
    }

    #[AuthRouterRegister(routerName: 'Criar', role: "ROLE_ADMIN_USER_CREATE", description: '...')]
    ##[IsGranted(data: "ROLE_ADMIN_USER_CREATE")]
    public function createAction(Request $request): Response
    {
        return parent::createAction($request);
    }

    #[AuthRouterRegister(routerName: 'Editar', role: "ROLE_ADMIN_USER_EDIT", description: '...')]
    ##[IsGranted(data: "ROLE_ADMIN_USER_EDIT")]
    public function editAction(Request $request): Response
    {
        return parent::editAction($request);
    }

    #[AuthRouterRegister(routerName: 'Excluir', role: "ROLE_ADMIN_USER_DELETE", description: '...')]
    ##[IsGranted(data: "ROLE_ADMIN_USER_DELETE")]
    public function deleteAction(Request $request): Response
    {
        return parent::deleteAction($request);
    }

    #[AuthRouterRegister(routerName: 'Excluir em Lote', role: "ROLE_ADMIN_USER_BATCH", description: '...')]
    ##[IsGranted(data: "ROLE_ADMIN_USER_DELETE")]
    public function batchAction(Request $request): Response
    {
        return parent::batchAction($request);
    }

    ##[IsGranted(data: "ROLE_ADMIN_USER_DELETE")]
    public function batchActionDelete(ProxyQueryInterface $query): Response
    {
        return parent::batchActionDelete($query);
    }

    #[AuthRouterRegister(routerName: 'Exportar', role: "ROLE_ADMIN_USER_EXPORT", description: '...')]
    ##[IsGranted(data: "ROLE_ADMIN_USER_EXPORT")]
    public function exportAction(Request $request): Response
    {
        return parent::exportAction($request);
    }

    #[AuthRouterRegister(routerName: 'Auditoria', role: "ROLE_ADMIN_USER_AUDIT", description: '...')]
    ##[IsGranted(data: "ROLE_ADMIN_USER_AUDIT")]
    public function historyAction(Request $request): Response
    {
        return parent::historyAction($request);
    }

    ##[IsGranted(data: "ROLE_ADMIN_USER_AUDIT")]
    public function historyViewRevisionAction(Request $request, string $revision): Response
    {
        return parent::historyViewRevisionAction($request, $revision);
    }

    ##[IsGranted(data: "ROLE_ADMIN_USER_AUDIT")]
    public function historyCompareRevisionsAction(Request $request, string $baseRevision, string $compareRevision): Response
    {
        return parent::historyCompareRevisionsAction($request, $baseRevision, $compareRevision);
    }




}