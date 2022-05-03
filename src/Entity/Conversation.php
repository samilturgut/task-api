<?php

namespace App\Entity;

use App\Enum\Status;
use App\Repository\ConversationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConversationRepository::class)]
class Conversation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    
    #[ORM\Column(type: 'string', length: 255)]
    private $message;
    
    #[ORM\Column(type: 'integer')]
    private int $status = Status::ACTIVE;
    
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'conversations')]
    private $user;
    
    #[ORM\ManyToOne(targetEntity: Task::class, inversedBy: 'conversations')]
    private $task;
    
    use Timestampable;
    
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }
    
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }
    
    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }
    
    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }
    
    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }
    
    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }
    
    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }
    
    /**
     * @return mixed
     */
    public function getTask()
    {
        return $this->task;
    }
    
    /**
     * @param mixed $task
     */
    public function setTask($task): void
    {
        $this->task = $task;
    }
}
