<?php

namespace App\Application\Project\UserBundle\Controller;

use App\Application\Project\AdminBundle\Attributes\AuthRouterRegister;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Application\Project\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\Security\Core\User\UserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

##[IsGranted('IS_AUTHENTICATED_FULLY')]
#[AuthRouterRegister(groupName: 'Usuarios', description: 'Permissões Api do modulo de Usuarios')]
#[Route('/api', name: 'api_')]
class UserApiController extends AbstractController
{
    private ?JWTTokenManagerInterface $JWTManager = null;

    public function __construct(JWTTokenManagerInterface $jwt = null) {
        $this->JWTManager = $jwt;
    }


    #[OA\Tag(name: 'Authentication')]
    #[OA\Response(
        response: 200,
        description: 'Return list of users',
    )]
    #[Route('/login', name: 'api_user_login', methods: ['POST'])]
    public function loginAction(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->find(1);

        $token = $this->JWTManager->create($user);

        return $this->json(['token' => $token]);
    }


    #[OA\Tag(name: 'user')]
    #[OA\Response(
        response: 200,
        description: 'Return list of users',
        #content: new Model(type: User::class)
        content: new OA\JsonContent(ref: new Model(type: User::class))
    )]
    ##[OA\RequestBody()]
    ##[IsGranted('IS_AUTHENTICATED_FULLY')]
    ##[IsGranted('ROLE_API_LIST')]
    #[Route('/user', name: 'api_user_list', methods: ['GET'])]
    #[AuthRouterRegister(routerName: 'Listar', role: "ROLE_API_USER_LIST", description: 'Lista todos os usuarios do cadastrados.')]
    public function listAction(ManagerRegistry $doctrine): Response
    {
        #$this->denyAccessUnlessGranted('ROLE_API_DASHBOARDS');

        $users = $doctrine->getRepository(User::class)->findAll();

        $data = [];

        foreach ($users as $user) {
            $data[] = [
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'roles' => $user->getRoles(),
            ];
        }

        return $this->json($data);
    }

    #[OA\Tag(name: 'user')]
    #[Route('/user', name: 'api_user_create', methods: ['POST'])]
    #[OA\Response(
        response: 200,
        description: 'Create a new User',
        content: new Model(type: User::class)
    )]
    #[OA\RequestBody()]
    #[AuthRouterRegister(routerName: 'Criar', role: "ROLE_API_USER_CREATE", description: 'Cria um novo usuario.')]
    public function createAction(ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $entityManager = $doctrine->getManager();

        $decoded = json_decode($request->getContent());
        $username = $decoded->username;
        $email = $decoded->email;
        $plaintextPassword = $decoded->password;

        $user = new User();

        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($passwordHasher->hashPassword($user, $plaintextPassword));

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json('Created new {user} successfully with id ' . $user->getId());
    }

    #[OA\Tag(name: 'user')]
    #[Route('/user/{id}', name: 'api_user_show', methods: ['GET'])]
    #[AuthRouterRegister(routerName: 'Visualizar', role: "ROLE_API_USER_SHOW", description: 'Exibe as informações de um usuario.')]
    public function showAction(ManagerRegistry $doctrine, int $id): Response
    {
        $user = $doctrine->getRepository(User::class)->find($id);

        if (!$user) {
            return $this->json('No user found for id' . $id, 404);
        }

        $data = [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
        ];

        return $this->json($data);
    }


    #[OA\Tag(name: 'user')]
    #[Route('/user/{id}', name: 'api_user_edit', methods: ['PUT'])]
    #[AuthRouterRegister(routerName: 'Editar', role: "ROLE_API_USER_EDIT", description: 'Edita as informações de um usuario.')]
    public function editAction(ManagerRegistry $doctrine, Request $request, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            return $this->json('No user found for id' . $id, 404);
        }

        $decoded = json_decode($request->getContent());
        $username = $decoded->username;
        $email = $decoded->email;

        $user->setUsername($username);
        $user->setEmail($email);

        $entityManager->persist($user);
        $entityManager->flush();

        $data = [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
        ];

        return $this->json($data);
    }


    #[OA\Tag(name: 'user')]
    #[Route('/user/{id}', name: 'api_user_delete', methods: ['DELETE'])]
    #[AuthRouterRegister(routerName: 'Deletar', role: "ROLE_API_USER_DELETE", description: 'Deleta as informações de um usuario.')]
    public function deleteAction(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            return $this->json('No user found for id' . $id, 404);
        }

        $entityManager->remove($user);
        $entityManager->flush();

        return $this->json('Deleted a user successfully with id ' . $id);
    }

}