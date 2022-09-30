<?php

namespace App\Application\Project\UserBundle\Controller;

use App\Application\Project\AdminBundle\Attributes\AuthRouterRegister;
use App\Application\Project\AdminBundle\Controller\CRUDBaseController;
use Laminas\Code\Reflection\ClassReflection;
use Laminas\Code\Reflection\FunctionReflection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


#[AuthRouterRegister(groupName: 'Grupo', description: 'Permissões do modulo Grupo')]
class GroupAdminController extends CRUDController
{

    #[AuthRouterRegister(
        routerName: 'Listar',
        description: '...',
        role: "ROLE_ADMIN_GROUP_LIST"
    )]
    #[IsGranted(data: "ROLE_ADMIN_GROUP_LIST")]
    public function listAction(Request $request): Response
    {
        return parent::listAction($request);
    }

    #[AuthRouterRegister(
        routerName: 'Exibir',
        description: '...',
        role: "ROLE_ADMIN_GROUP_SHOW"
    )]
    #[IsGranted(data: "ROLE_ADMIN_GROUP_SHOW")]
    public function showAction(Request $request): Response
    {
        return parent::showAction($request);
    }

    #[AuthRouterRegister(
        routerName: 'Criar',
        description: '...',
        role: "ROLE_ADMIN_GROUP_CREATE"
    )]
    #[IsGranted(data: "ROLE_ADMIN_GROUP_CREATE")]
    public function createAction(Request $request): Response
    {
        return parent::createAction($request);
    }

    #[AuthRouterRegister(
        routerName: 'Editar',
        description: '...',
        role: "ROLE_ADMIN_GROUP_EDIT"
    )]
    #[IsGranted(data: "ROLE_ADMIN_GROUP_EDIT")]
    public function editAction(Request $request): Response
    {
        return parent::editAction($request);
    }

    #[AuthRouterRegister(
        routerName: 'Deletar',
        description: '...',
        role: "ROLE_ADMIN_GROUP_DELETE"
    )]
    #[IsGranted(data: "ROLE_ADMIN_GROUP_DELETE")]
    public function deleteAction(Request $request): Response
    {
        return parent::deleteAction($request);
    }

    #[AuthRouterRegister(
        routerName: 'Deletar Em Lote',
        description: '...',
        role: "ROLE_ADMIN_GROUP_BATCH"
    )]
    #[IsGranted(data: "ROLE_ADMIN_GROUP_BATCH")]
    public function batchAction(Request $request): Response
    {
        return parent::batchAction($request);
    }

    #[IsGranted(data: "ROLE_ADMIN_GROUP_BATCH")]
    public function batchActionDelete(ProxyQueryInterface $query): Response
    {
        return parent::batchActionDelete($query);
    }

    #[AuthRouterRegister(
        routerName: 'Exportar',
        description: '...',
        role: "ROLE_ADMIN_GROUP_EXPORT"
    )]
    #[IsGranted(data: "ROLE_ADMIN_GROUP_EXPORT")]
    public function exportAction(Request $request): Response
    {
        return parent::exportAction($request);
    }

    #[AuthRouterRegister(
        routerName: 'Auditoria',
        description: '...',
        role: "ROLE_ADMIN_GROUP_AUDIT"
    )]
    #[IsGranted(data: "ROLE_ADMIN_GROUP_AUDIT")]
    public function historyAction(Request $request): Response
    {
        return parent::historyAction($request);
    }

    #[IsGranted(data: "ROLE_ADMIN_GROUP_AUDIT")]
    public function historyViewRevisionAction(Request $request, string $revision): Response
    {
        return parent::historyViewRevisionAction($request, $revision);
    }

    #[IsGranted(data: "ROLE_ADMIN_GROUP_AUDIT")]
    public function historyCompareRevisionsAction(Request $request, string $baseRevision, string $compareRevision): Response
    {
        return parent::historyCompareRevisionsAction($request, $baseRevision, $compareRevision);
    }




}