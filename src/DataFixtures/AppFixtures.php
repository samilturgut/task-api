<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Task;
use App\Entity\User;
use App\Enum\Status;
use App\Enum\TaskPriority;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $hasher;
    
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('user@samil.turgut');
        $password = $this->hasher->hashPassword($user, '123456');
        $user->setPassword($password);
        $user->addRole('ROLE_USER');
        $manager->persist($user);
        
        $expert = new User();
        $expert->setEmail('expert@samil.turgut');
        $password = $this->hasher->hashPassword($user, '123456');
        $expert->setPassword($password);
        $expert->addRole('ROLE_USER');
        $expert->addRole('ROLE_EXPERT');
        $manager->persist($expert);
        
        $category = new Category();
        $category->setName('Category 1');
        $category->setCreatedAt(new \DateTime());
        $manager->persist($category);
        
        $category2 = new Category();
        $category2->setName('Category 2');
        $category2->setCreatedAt(new \DateTime());
        $manager->persist($category2);
        
        $task = new Task();
        $task->setContent('Task 1');
        $task->setStatus(Status::ACTIVE);
        $task->setPriority(TaskPriority::NORMAL);
        $task->setUser($user);
        $task->addCategory($category);
        $task->setCreatedAt(new \DateTime());
        $manager->persist($task);
        
        $task2 = new Task();
        $task2->setContent('Task 2');
        $task2->setStatus(Status::ACTIVE);
        $task2->setPriority(TaskPriority::NORMAL);
        $task2->setUser($expert);
        $task2->addCategory($category);
        $task2->addCategory($category2);
        $task2->setCreatedAt(new \DateTime());
        $manager->persist($task2);

        $manager->flush();
    }
}
