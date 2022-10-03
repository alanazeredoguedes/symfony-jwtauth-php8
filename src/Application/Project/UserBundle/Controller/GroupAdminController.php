<?php

namespace App\Application\Project\UserBundle\Controller;

use App\Application\Project\ContentBundle\Attributes\ARR;
use App\Application\Project\ContentBundle\Controller\DefaultCRUDController;
use App\Application\Project\ContentBundle\Service\RolesIdentifierService;
use ReflectionException;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[ARR(groupName: 'Grupo', description: 'Permissões do modulo Grupo')]
class GroupAdminController extends DefaultCRUDController
{

    #[ARR(routerName: 'listAction', role: "ROLE_ADMIN_GROUP_LIST", title: 'Listar', description: 'Lista todos os grupos')]
    protected string $listAction = "ROLE_ADMIN_GROUP_LIST";

    #[ARR(routerName: 'showAction', role: "ROLE_ADMIN_GROUP_SHOW", title: 'Visualizar')]
    protected string $showAction = "ROLE_ADMIN_GROUP_SHOW";

    #[ARR(routerName: 'createAction', role: "ROLE_ADMIN_GROUP_CREATE", title: 'Criar')]
    protected string $createAction = "ROLE_ADMIN_GROUP_CREATE";

    #[ARR(routerName: 'editAction', role: "ROLE_ADMIN_GROUP_EDIT", title: 'Editar')]
    protected string $editAction  = "";

    #[ARR(routerName: 'deleteAction', role: "ROLE_ADMIN_GROUP_DELETE", title: 'Excluir')]
    protected string $deleteAction = "ROLE_ADMIN_GROUP_DELETE";

    #[ARR(routerName: 'batchAction', role: "ROLE_ADMIN_GROUP_BATCH", title: 'Excluir em Lote')]
    protected string $batchAction = "ROLE_ADMIN_GROUP_BATCH";

    #[ARR(routerName: 'exportAction', role: "ROLE_ADMIN_GROUP_EXPORT", title: 'Exportar')]
    protected string $exportAction = "ROLE_ADMIN_GROUP_EXPORT";

    #[ARR(routerName: 'historyAction', role: "ROLE_ADMIN_GROUP_HISTORY", title: 'Auditoria')]
    protected string $historyAction = "ROLE_ADMIN_GROUP_AUDIT";

    private RolesIdentifierService $rolesIdentifierService;


    public function __construct(RolesIdentifierService $rolesIdentifierService)
    {
        $this->rolesIdentifierService = $rolesIdentifierService;
    }

    /** @throws ReflectionException */
    public function listAllRolesAction(): JsonResponse
    {
        /** Access Control Validate */
        //$this->denyAccessUnlessGranted($this->listAction);

        return $this->json($this->rolesIdentifierService->getAllGroupRoles());
    }




}