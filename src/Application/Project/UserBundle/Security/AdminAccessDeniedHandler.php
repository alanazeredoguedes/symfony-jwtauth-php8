<?php
namespace App\Application\Project\UserBundle\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AdminAccessDeniedHandler implements AccessDeniedHandlerInterface
{
    public function handle(Request $request, AccessDeniedException $accessDeniedException): ?Response
    {

        return new JsonResponse([
            "code" => 403,
            #"message"=> "Sem Permissão de Acesso ao Recurso",
            "message"=> "Sem Permissão De Acesso Ao Recurso",
        ], 403);


    }
}