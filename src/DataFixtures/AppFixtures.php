<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
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
        $category->setCreatedAt();
        $manager->persist($category);
        
        $category2 = new Category();
        $category2->setName('Category 2');
        $category2->setCreatedAt();
        $manager->persist($category2);

        $manager->flush();
        
    }
}
