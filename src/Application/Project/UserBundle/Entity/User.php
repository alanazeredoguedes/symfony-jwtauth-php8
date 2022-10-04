<?php

namespace App\Application\Project\UserBundle\Entity;

use App\Application\Project\UserBundle\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use OpenApi\Attributes as OA;

#[ORM\Table(name: '_user')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    /** @var ?string The hashed password */
    #[ORM\Column]
    #[OA\Property(writeOnly: true)]
    private ?string $password = null;

    #[ORM\Column(name: 'roles', unique: false)]
    #[OA\Property(type: 'object')]
    private array $roles = [];

    #[ORM\Column(name: 'admin_roles', unique: false)]
    #[OA\Property(type: 'object')]
    private array $adminRoles = [];

    #[ORM\Column(name: 'api_roles', unique: false)]
    #[OA\Property(type: 'object')]
    private array $apiRoles = [];

    #[ORM\ManyToMany(targetEntity: "App\Application\Project\UserBundle\Entity\Group")]
    #[ORM\JoinTable(name: "user_group")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    #[ORM\InverseJoinColumn(name: "group_id", referencedColumnName: "id")]
    private $groups;


    public function __construct()
    {
        $this->groups = new ArrayCollection();
    }

    /**
     * Criar Roles direta para os usuarios
     */

    /**
     * Criar Relacionamento de usuario com grupo
     */


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        /** Traz todas as ROLES que o usuário individualmente possui! */

        $rolesAdmin = $this->getAdminRoles();
        $rolesApi = $this->getApiRoles();

        foreach ($this->getGroups() as $group) {
            $rolesAdmin = array_merge( $rolesAdmin, $group->getAdminRoles() );
            $rolesApi = array_merge( $rolesApi, $group->getApiRoles() );
        }

        $roles = array_merge( $roles, $rolesAdmin, $rolesApi );

        return array_unique(array_values(array_filter($roles)));
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getGroups()
    {
        return $this->groups;
    }

    public function setGroups($groups)
    {
        $this->groups = $groups;
    }

    /** @return array */
    public function getAdminRoles(): array
    {
        $roles = $this->adminRoles;

        return array_unique(array_values(array_filter($roles)));
    }

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

    public function setApiRoles(array $apiRoles): void
    {
        $this->apiRoles = $apiRoles;
    }


}
