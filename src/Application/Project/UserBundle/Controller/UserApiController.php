<?php

namespace App\Application\Project\UserBundle\Controller;

use App\Application\Project\UserBundle\Entity\User;
use Nelmio\ApiDocBundle\Model\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/api', name: 'api_')]
class UserApiController extends AbstractController
{

    #[Route('/user', name: 'api_user_list', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Retorna lista de usuarios',
        #content: new Model(type: User::class)
    )]
    #[IsGranted('ROLE_USER')]
    #[IsGranted('ROLE_API_DASHBOARDS')]
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

    #[Route('/user', name: 'api_user_create', methods: ['POST'])]
    public function createAction(ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();

        $user = new User();
        $user->setUsername($request->request->get('username'));
        $user->setEmail($request->request->get('email'));
        $user->setPassword($request->request->get('password'));

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json('Created new {user} successfully with id ' . $user->getId());
    }

    #[Route('/user/{id}', name: 'api_user_show', methods: ['GET'])]
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


    #[Route('/user/{id}', name: 'api_user_edit', methods: ['PUT'])]
    public function editAction(ManagerRegistry $doctrine, Request $request, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            return $this->json('No user found for id' . $id, 404);
        }

        $user->setUsername($request->request->get('username'));
        $user->setEmail($request->request->get('email'));
        $user->setPassword($request->request->get('password'));

        //$entityManager->persist($user);
        $entityManager->flush();

        $data = [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
        ];

        return $this->json($data);
    }


    #[Route('/user/{id}', name: 'api_user_delete', methods: ['DELETE'])]
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