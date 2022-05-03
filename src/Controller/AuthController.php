<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\AuthService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class AuthController extends BaseController
{
    #[Route('/api/login', name: 'api.login', methods: ['POST'])]
    public function login(#[CurrentUser] ?User $user, AuthService $authService): Response
    {
        if (null === $user) {
            throw new AuthenticationException('Invalid credentials.', Response::HTTP_UNAUTHORIZED);
        }
        
        $token = $authService->createToken($user);
        
        return $this->_success(['token' => $token]);
    }
    
    #[Route('/api/logout', name: 'api.logout', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function logout(AuthService $authService): Response
    {
        $authService->logout($this->getUser());
        
        return $this->_success([]);
    }
}
