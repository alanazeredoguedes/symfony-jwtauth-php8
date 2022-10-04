<?php

namespace App\Application\Project\UserBundle\Controller;

use App\Application\Project\ContentBundle\Attributes\ARR;
use App\Application\Project\ContentBundle\Controller\DefaultAbstractController;
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
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


##[IsGranted('IS_AUTHENTICATED_FULLY')]
#[ARR(groupName: 'Usuários', description: 'Permissões Api do modulo de Usuários')]
#[Route('/api', name: 'api_')]
class UserApiController extends DefaultAbstractController
{
    private ?JWTTokenManagerInterface $JWTManager = null;

    public function __construct(JWTTokenManagerInterface $jwt = null) {
        $this->JWTManager = $jwt;
    }

    #[OA\Tag(name: 'user')]
    #[OA\Response(
        response: 200,
        description: 'Return Token JWT',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'token', description: 'Token JWT', type: 'string', nullable: false),
            ],
            type: 'object'
        )
    )]
    #[OA\RequestBody(
        description: 'Json Payload',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'email', description: 'Email do Usuário', type: 'string', nullable: false),
                new OA\Property(property: 'password', description: 'Senha do Usuário', type: 'string', nullable: false)
            ],
            type: 'object'
        )
    )]
    #[Route('/user/login', name: 'user_login', methods: ['POST'])]
    public function loginAction(ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $entityManager = $doctrine->getManager();

        $parameters = [
            'email'     => [ 'type' => 'string', 'required' => true, 'nullable' => false ],
            'password'  => [ 'type' => 'string', 'required' => true, 'nullable' => false ],
        ];

        $requestBody = json_decode($request->getContent());

        if($this->validateJsonRequestBody($requestBody, $parameters))
            return $this->validateJsonRequestBody($requestBody, $parameters);



        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $requestBody->email]);

        if(!$user || !$passwordHasher->isPasswordValid($user, $requestBody->password))
            return $this->createResponseStatus(message: 'Invalid access credentials');

        $token = $this->JWTManager->create($user);

        return $this->json(['token' => $token]);
    }


    /**
     * @throws ExceptionInterface
     */
    #[OA\Tag(name: 'user')]
    #[OA\Response(
        response: 200,
        description: 'Return authenticated user',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'id', type: 'int'),
                new OA\Property(property: 'username', type: 'string'),
                new OA\Property(property: 'email', type: 'string'),
                new OA\Property(property: 'groups', type: 'object'),
            ],
            type: 'object'
        )
    )]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/user/authenticated', name: 'user_by_token', methods: ['GET'])]
    public function userByTokenAction(ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $user = $this->getUser();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $data = $serializer->normalize($user, null, [AbstractNormalizer::ATTRIBUTES => [
            'id',
            'username',
            'email',
            'groups' => ['id', 'name', 'description']
        ] ]);

        return $this->json($data);
    }


    protected function getListItem($list, $getProperty){
        $response = [];
        foreach ($list as $item){
            $response[] = $item->$$getProperty;
        }
        return $response;
    }



    #[OA\Tag(name: 'user')]
    #[OA\Response(
        response: 200,
        description: 'Return list of user',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'id', type: 'int'),
                new OA\Property(property: 'username', type: 'string'),
                new OA\Property(property: 'email', type: 'string'),
                new OA\Property(property: 'groups', type: 'object'),
            ],
            type: 'object'
        )
    )]
    #[IsGranted('ROLE_API_USER_LIST')]
    #[ARR(routerName: 'listAction', role: "ROLE_API_USER_LIST", title: 'Listar')]
    #[Route('/user', name: 'user_list', methods: ['GET'])]
    public function listAction(ManagerRegistry $doctrine): Response
    {
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
    #[Route('/user', name: 'user_create', methods: ['POST'])]
    #[OA\Response(
        response: 200,
        description: 'Create a new User',
        content: new Model(type: User::class)
    )]
    #[OA\RequestBody()]
    #[IsGranted('ROLE_API_USER_CREATE')]
    #[ARR(routerName: 'createAction', role: "ROLE_API_USER_CREATE", title: 'Criar')]
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
    #[Route('/user/{id}', name: 'user_show', methods: ['GET'])]
    #[IsGranted('ROLE_API_USER_SHOW')]
    #[ARR(routerName: 'showAction', role: "ROLE_API_USER_SHOW", title: 'Visualizar')]
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
    #[Route('/user/{id}', name: 'user_edit', methods: ['PUT'])]
    #[IsGranted('ROLE_API_USER_EDIT')]
    #[ARR(routerName: 'editAction', role: "ROLE_API_USER_EDIT", title: 'Editar')]
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
    #[Route('/user/{id}', name: 'user_delete', methods: ['DELETE'])]
    #[IsGranted('ROLE_API_USER_DELETE')]
    #[ARR(routerName: 'deleteAction', role: "ROLE_API_USER_DELETE", title: 'Deletar')]
    public function deleteAction(ManagerRegistry $doctrine, int $id): Response
    {
        $this->validateAccess('ROLE_API_USER_DELETE');

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