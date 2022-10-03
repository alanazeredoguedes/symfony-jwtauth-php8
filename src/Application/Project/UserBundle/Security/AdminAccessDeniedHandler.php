<?php
namespace App\Application\Project\UserBundle\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AdminAccessDeniedHandler implements AccessDeniedHandlerInterface
{

    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }

    /**
     * Admin Error 403 Redirect
     * @param Request $request
     * @param AccessDeniedException $accessDeniedException
     * @return Response|null
     */
    public function handle(Request $request, AccessDeniedException $accessDeniedException): ?Response
    {

        return new RedirectResponse($this->urlGenerator->generate('admin_project_content_content_accessDenied'));

/*        return new JsonResponse([
            "code" => 403,
            #"message"=> "Sem Permissão de Acesso ao Recurso",
            "message"=> "Sem Permissão De Acesso Ao Recurso",
        ], 403);*/


    }
}