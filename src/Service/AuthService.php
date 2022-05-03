<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthService extends AbstractService
{
    public function createToken(User $user): bool|string
    {
        $token = hash('sha256', $user->getEmail().$user->getId().time());
        
        $user->setToken($token);
        $this->_em->persist($user);
        $this->_em->flush();
    
        return $token;
    }
    
    public function logout(UserInterface $user): void
    {
        $user->setToken(null);
        $this->_em->persist($user);
        $this->_em->flush();
    }
}