<?php

namespace App\Application\Project\UserBundle\Controller;
use App\Application\Project\ContentBundle\Attributes\ARR;
use App\Application\Project\ContentBundle\Controller\DefaultCRUDController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[ARR(groupName: 'Usuario', description: 'Permissões do modulo de Usuario')]
class UserAdminController extends DefaultCRUDController
{
    #[ARR(routerName: 'listAction', role: "ROLE_ADMIN_USER_LIST", title: 'Listar')]
    protected string $listAction = "ROLE_ADMIN_USER_LIST";

    #[ARR(routerName: 'showAction', role: "ROLE_ADMIN_USER_SHOW", title: 'Visualizar')]
    protected string $showAction = "ROLE_ADMIN_USER_SHOW";

    #[ARR(routerName: 'createAction', role: "ROLE_ADMIN_USER_CREATE", title: 'Criar')]
    protected string $createAction = "ROLE_ADMIN_USER_CREATE";

    #[ARR(routerName: 'editAction', role: "ROLE_ADMIN_USER_EDIT", title: 'Editar')]
    protected string $editAction  = "ROLE_ADMIN_USER_EDIT";

    #[ARR(routerName: 'deleteAction', role: "ROLE_ADMIN_USER_DELETE", title: 'Excluir')]
    protected string $deleteAction = "ROLE_ADMIN_USER_DELETE";

    #[ARR(routerName: 'batchAction', role: "ROLE_ADMIN_USER_BATCH", title: 'Excluir em Lote')]
    protected string $batchAction = "ROLE_ADMIN_USER_BATCH";

    #[ARR(routerName: 'exportAction', role: "ROLE_ADMIN_USER_EXPORT", title: 'Exportar')]
    protected string $exportAction = "ROLE_ADMIN_USER_EXPORT";

    #[ARR(routerName: 'historyAction', role: "ROLE_ADMIN_USER_HISTORY", title: 'Auditoria')]
    protected string $historyAction = "ROLE_ADMIN_USER_HISTORY";



}