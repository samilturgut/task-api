<?php

namespace App\Entity;

use App\Enum\Status;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    
    #[ORM\Column(type: 'string', length: 255)]
    private $name;
    
    #[ORM\Column(type: 'integer')]
    private int $status = Status::ACTIVE;
    
    #[ORM\ManyToMany(targetEntity: Task::class, mappedBy: 'categories', fetch: 'EXTRA_LAZY')]
    private $tasks;
    
    use Timestampable;
    
    public function __construct()
    {
        $this->tasks = new ArrayCollection();
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
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
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
     * @return ArrayCollection
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }
    
    /**
     * @param ArrayCollection $tasks
     */
    public function setTasks(ArrayCollection $tasks): void
    {
        $this->tasks = $tasks;
    }
    
    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
        }
        return $this;
    }
    
    public function removeTask(Task $task): self
    {
        $this->tasks->removeElement($task);
        
        return $this;
    }
}
