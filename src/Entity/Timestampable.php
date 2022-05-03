<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

trait Timestampable
{
    #[ORM\Column(type: 'datetime')]
    private $createdAt;
    
    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updatedAt;
    
    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt(): void
    {
        $this->createdAt = new \DateTime();
    }
    
    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}