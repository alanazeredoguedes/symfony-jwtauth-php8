<?php

namespace App\Application\Project\UserBundle\Controller;

use App\Application\Project\AdminBundle\Attributes\AuthRouterRegister;
use App\Application\Project\AdminBundle\Controller\CRUDBaseController;
use App\Application\Project\AdminBundle\Service\RolesIdentifierService;
use Laminas\Code\Reflection\ClassReflection;
use Laminas\Code\Reflection\FunctionReflection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Exception\ModelManagerException;
use Sonata\AdminBundle\Exception\ModelManagerThrowable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


#[AuthRouterRegister(groupName: 'Grupo', description: 'Permissões do modulo Grupo')]
class GroupAdminController extends CRUDController
{
    private RolesIdentifierService $rolesIdentifierService;

    public function __construct(RolesIdentifierService $rolesIdentifierService)
    {
        $this->rolesIdentifierService = $rolesIdentifierService;
    }

    ##[IsGranted(data: "ROLE_ADMIN_GROUP_LIST")]
    #[AuthRouterRegister(routerName: 'Listar', role: "ROLE_ADMIN_GROUP_LIST", description: 'Lista todos os grupos do cadastrados.')]
    public function listAction(Request $request): Response
    {
        return parent::listAction($request);
    }

    ##[IsGranted("ROLE_ADMIN_GROUP_SHOW")]
    #[AuthRouterRegister(routerName: 'Visualizar', role: "ROLE_ADMIN_GROUP_SHOW", description: '...')]
    public function showAction(Request $request): Response
    {
        return parent::showAction($request);
    }

    #[AuthRouterRegister(routerName: 'Criar', role: "ROLE_ADMIN_GROUP_CREATE", description: '...')]
    ##[IsGranted(data: "ROLE_ADMIN_GROUP_CREATE")]
    public function createAction(Request $request): Response
    {
        return parent::createAction($request);
    }

    #[AuthRouterRegister(routerName: 'Editar', role: "ROLE_ADMIN_GROUP_EDIT", description: '...')]
    ##[IsGranted(data: "ROLE_ADMIN_GROUP_EDIT")]
    public function editAction(Request $request): Response
    {
        return parent::editAction($request);
    }

    #[AuthRouterRegister(routerName: 'Excluir', role: "ROLE_ADMIN_GROUP_DELETE", description: '...')]
    ##[IsGranted(data: "ROLE_ADMIN_GROUP_DELETE")]
    public function deleteAction(Request $request): Response
    {
        return parent::deleteAction($request);
    }

    #[AuthRouterRegister(routerName: 'Excluir em Lote', role: "ROLE_ADMIN_GROUP_BATCH", description: '...')]
    ##[IsGranted(data: "ROLE_ADMIN_GROUP_DELETE")]
    public function batchAction(Request $request): Response
    {
        return parent::batchAction($request);
    }

    ##[IsGranted(data: "ROLE_ADMIN_GROUP_DELETE")]
    public function batchActionDelete(ProxyQueryInterface $query): Response
    {
        return parent::batchActionDelete($query);
    }

    #[AuthRouterRegister(routerName: 'Exportar', role: "ROLE_ADMIN_GROUP_EXPORT", description: '...')]
    ##[IsGranted(data: "ROLE_ADMIN_GROUP_EXPORT")]
    public function exportAction(Request $request): Response
    {
        return parent::exportAction($request);
    }

    #[AuthRouterRegister(routerName: 'Auditoria', role: "ROLE_ADMIN_GROUP_AUDIT", description: '...')]
    ##[IsGranted(data: "ROLE_ADMIN_GROUP_AUDIT")]
    public function historyAction(Request $request): Response
    {
        return parent::historyAction($request);
    }

    ##[IsGranted(data: "ROLE_ADMIN_GROUP_AUDIT")]
    public function historyViewRevisionAction(Request $request, string $revision): Response
    {
        return parent::historyViewRevisionAction($request, $revision);
    }

    ##[IsGranted(data: "ROLE_ADMIN_GROUP_AUDIT")]
    public function historyCompareRevisionsAction(Request $request, string $baseRevision, string $compareRevision): Response
    {
        return parent::historyCompareRevisionsAction($request, $baseRevision, $compareRevision);
    }


    public function listAllRolesAction()
    {
        $adminRoles = $this->rolesIdentifierService->getAdminRoles();
        $apiRoles = $this->rolesIdentifierService->getApiRoles();

        $data = [
            'adminRoles' => $adminRoles,
            'apiRoles' => $apiRoles,
        ];
        return $this->json($data);
    }




}