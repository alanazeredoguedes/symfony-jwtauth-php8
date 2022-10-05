<?php

namespace App\Application\Project\UserBundle\Controller;

use App\Application\Project\ContentBundle\Attributes\ARR;
use App\Application\Project\ContentBundle\Controller\DefaultCRUDController;
use App\Application\Project\ContentBundle\Service\RolesIdentifierService;
use ReflectionException;
use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[ARR(groupName: 'Grupo', description: 'Permissões do modulo Grupo')]
class GroupAdminController extends DefaultCRUDController
{
    private RolesIdentifierService $rolesIdentifierService;

    public function __construct(RolesIdentifierService $rolesIdentifierService)
    {
        $this->rolesIdentifierService = $rolesIdentifierService;
    }

    #[ARR(routerName: 'listAction', role: "ROLE_ADMIN_GROUP_LIST", title: 'Listar')]
    public function listAction(Request $request): Response
    {
        /** Access Control Validate */
        $this->validateAccess("ROLE_ADMIN_GROUP_LIST");

        return parent::listAction($request);
    }

    #[ARR(routerName: 'showAction', role: "ROLE_ADMIN_GROUP_SHOW", title: 'Visualizar')]
    public function showAction(Request $request): Response
    {
        /** Access Control Validate */
        $this->validateAccess("ROLE_ADMIN_GROUP_SHOW");

        return parent::showAction($request);
    }

    #[ARR(routerName: 'createAction', role: "ROLE_ADMIN_GROUP_CREATE", title: 'Criar')]
    public function createAction(Request $request): Response
    {
        /** Access Control Validate */
        $this->validateAccess("ROLE_ADMIN_GROUP_CREATE");

        return parent::createAction($request);
    }

    #[ARR(routerName: 'editAction', role: "ROLE_ADMIN_GROUP_EDIT", title: 'Editar')]
    public function editAction(Request $request): Response
    {
        /** Access Control Validate */
        $this->validateAccess("ROLE_ADMIN_GROUP_EDIT");

        return parent::editAction($request);
    }

    #[ARR(routerName: 'deleteAction', role: "ROLE_ADMIN_GROUP_DELETE", title: 'Excluir')]
    public function deleteAction(Request $request): Response
    {
        /** Access Control Validate */
        $this->validateAccess("ROLE_ADMIN_GROUP_DELETE");

        return parent::deleteAction($request);
    }

    #[ARR(routerName: 'batchAction', role: "ROLE_ADMIN_GROUP_BATCH", title: 'Excluir em Lote')]
    public function batchActionDelete(ProxyQueryInterface $query): Response
    {
        /** Access Control Validate */
        $this->validateAccess("ROLE_ADMIN_GROUP_BATCH");

        return parent::batchActionDelete($query);
    }

    public function batchAction(Request $request): Response
    {
        /** Access Control Validate */
        $this->validateAccess("ROLE_ADMIN_GROUP_BATCH");

        return parent::batchAction($request);
    }

    #[ARR(routerName: 'exportAction', role: "ROLE_ADMIN_GROUP_EXPORT", title: 'Exportar')]
    public function exportAction(Request $request): Response
    {
        /** Access Control Validate */
        $this->validateAccess("ROLE_ADMIN_GROUP_EXPORT");

        return parent::exportAction($request);
    }

    #[ARR(routerName: 'historyAction', role: "ROLE_ADMIN_GROUP_HISTORY", title: 'Auditoria')]
    public function historyAction(Request $request): Response
    {
        /** Access Control Validate */
        $this->validateAccess("ROLE_ADMIN_GROUP_HISTORY");

        return parent::historyAction($request);
    }

    public function historyViewRevisionAction(Request $request, string $revision): Response
    {
        /** Access Control Validate */
        $this->validateAccess("ROLE_ADMIN_GROUP_HISTORY");


        return parent::historyViewRevisionAction($request, $revision);
    }

    public function historyCompareRevisionsAction(Request $request, string $baseRevision, string $compareRevision): Response
    {
        /** Access Control Validate */
        $this->validateAccess("ROLE_ADMIN_GROUP_HISTORY");

        return parent::historyCompareRevisionsAction($request, $baseRevision, $compareRevision);
    }

    /** @throws ReflectionException */
    public function listAllRolesAction(): JsonResponse
    {
        /** Access Control Validate */
        //$this->denyAccessUnlessGranted($this->listAction);

        return $this->json($this->rolesIdentifierService->getAllGroupRoles());
    }


}