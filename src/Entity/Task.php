<?php

namespace App\Entity;

use App\Enum\Status;
use App\Enum\TaskPriority;
use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    
    #[ORM\Column(type: 'text', nullable: false)]
    private string $content;
    
    #[ORM\Column(type: 'integer')]
    private int $priority = TaskPriority::NORMAL;
    
    #[ORM\Column(type: 'integer')]
    private int $status = Status::ACTIVE;
    
    #[ORM\Column(type: 'text', nullable: true)]
    private $closeDescription;
    
    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'tasks', fetch: 'EXTRA_LAZY')]
    private $categories;
    
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'tasks', fetch: 'EXTRA_LAZY')]
    private $user;
    
    #[ORM\OneToMany(targetEntity: Conversation::class, mappedBy: 'tasks')]
    private $conversation;
    
    use Timestampable;
    
    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->conversation = new ArrayCollection();
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
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }
    
    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }
    
    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }
    
    /**
     * @param int $priority
     */
    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
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
    public function getCloseDescription()
    {
        return $this->closeDescription;
    }
    
    /**
     * @param mixed $closeDescription
     */
    public function setCloseDescription($closeDescription): void
    {
        $this->closeDescription = $closeDescription;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }
    
    /**
     * @param array $categories
     */
    public function setCategories(array $categories): void
    {
        $this->categories = $categories;
    }
    
    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }
        
        return $this;
    }
    
    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }
        
        return $this;
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
     * @return ArrayCollection
     */
    public function getConversation(): Collection
    {
        return $this->conversation;
    }
    
    /**
     * @param ArrayCollection $conversation
     */
    public function setConversation(ArrayCollection $conversation): void
    {
        $this->conversation = $conversation;
    }
}
