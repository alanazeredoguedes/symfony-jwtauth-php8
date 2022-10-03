<?php

namespace App\Application\Project\ContentBundle\Service;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class AdminRoutesService
{
    private ?TokenInterface $tokenStorage;
    private RolesIdentifierService $rolesIdentifierService;

    public function __construct(TokenStorageInterface $tokenStorage, RolesIdentifierService $rolesIdentifierService)
    {
        $this->tokenStorage = $tokenStorage->getToken();
        $this->rolesIdentifierService = $rolesIdentifierService;
    }

    /**
 * Default Routes Name
 * list
 * create
 * batch
 * edit
 * delete
 * show
 * export
 * history
 * history_view_revision
 * history_compare_revisions
 */


    /**
     * Trazer todas as roles do usuario
     * Trazer todas as Annotations do usuario
     * Bater as permissoes com as anootatios
     * E remover as routeName que ele não tiver permissao
     */
    public function RoutesNotAccessible($user, $controllerName): array
    {
        if(!$user)
            return [];

        $routesRemove = [];

        $userRoles = $user->getRoles();

        $allSystemRoles = $this->rolesIdentifierService->getAllRolesByController($controllerName);

        foreach ($allSystemRoles as $systemRole) {
            if( !in_array($systemRole['role'], $userRoles) ){
                $routesRemove[] = str_replace("Action", "", $systemRole['routerName']);
            }
        }
        //dump($routesRemove);

        return $routesRemove;
    }

    protected function getUser()
    {
        //dump($this->tokenStorage);
        if (null === $token = $this->tokenStorage) {
            return null;
        }

        if (!is_object($user = $token->getUser())) {
            return null;
        }

        return $user;
    }

}