<?php

namespace App\Application\Project\UserBundle\Entity;

use App\Application\Project\UserBundle\Repository\GroupRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use OpenApi\Attributes as OA;

#[ORM\Table(name: '_group')]
#[ORM\Entity(repositoryClass: GroupRepository::class)]
class Group
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $name = null;

    #[ORM\Column(length: 180, unique: false, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(name: 'admin_roles', unique: false)]
    #[OA\Property(type: 'object')]
    private array $adminRoles = [];

    #[ORM\Column(name: 'api_roles', unique: false)]
    #[OA\Property(type: 'object')]
    private array $apiRoles = [];

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /** @return array */
    public function getAdminRoles(): array
    {
        $roles = $this->adminRoles;

        return array_unique(array_values(array_filter($roles)));
    }

    /** @param array $adminRoles */
    public function setAdminRoles(array $adminRoles): void
    {
        $this->adminRoles = $adminRoles;
    }

    /** @return array */
    public function getApiRoles(): array
    {
        $roles = $this->apiRoles;

        return array_unique(array_values(array_filter($roles)));
    }

    /** @param array $apiRoles */
    public function setApiRoles(array $apiRoles): void
    {
        $this->apiRoles = $apiRoles;
    }




}
