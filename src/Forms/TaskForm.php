<?php

namespace App\Forms;

use App\Enum\Status;
use Symfony\Component\Validator\Constraints as Assert;

class TaskForm
{
    
    #[Assert\Expression(
        "!(this.getStatus() != 4 and this.getContent() == null)",
        message: "Content is not empty."
    )]
    private $content;
    
    #[Assert\Expression(
        "!(this.getStatus() != 4 and this.getCategories() == null)",
        message: "Categories is not empty."
    )]
    private $categories;
    
    private $priority;
    
    private $status;
    
    #[Assert\Expression(
        "!(this.getStatus() == 4 and this.getCloseDescription() == null)",
        message: "Task must be closed with a description."
    )]
    private $closeDescription;
    
    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }
    
    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }
    
    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }
    
    /**
     * @param mixed $categories
     */
    public function setCategories($categories): void
    {
        $this->categories = $categories;
    }
    
    /**
     * @return mixed
     */
    public function getPriority()
    {
        return $this->priority;
    }
    
    /**
     * @param mixed $priority
     */
    public function setPriority($priority): void
    {
        $this->priority = $priority;
    }
    
    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status ?? Status::ACTIVE;
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
}