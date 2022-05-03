<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;
    
    #[ORM\Column(type: 'string', nullable: true)]
    private $token;
    
    #[ORM\OneToMany(targetEntity: Task::class, mappedBy: 'user')]
    private $tasks;
    
    #[ORM\OneToMany(targetEntity: Task::class, mappedBy: 'user')]
    private $conversations;

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function setId($id): void
    {
        $this->id = $id;
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
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        //$this->password = null;
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
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }
    
    /**
     * @see UserInterface
     */
    public function addRole(string $role): self
    {
        if (!isset($this->roles[$role])) {
            $this->roles[] = $role;
        }

        return $this;
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
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }
    
    /**
     * @param mixed $token
     */
    public function setToken($token): void
    {
        $this->token = $token;
    }
    
    /**
     * @return mixed
     */
    public function getTasks()
    {
        return $this->tasks;
    }
    
    /**
     * @param mixed $tasks
     */
    public function setTasks($tasks): void
    {
        $this->tasks = $tasks;
    }
    
    /**
     * @return mixed
     */
    public function getConversations()
    {
        return $this->conversations;
    }
    
    /**
     * @param mixed $conversations
     */
    public function setConversations($conversations): void
    {
        $this->conversations = $conversations;
    }
}
