<?php

namespace App\Event;

use App\Builder\Http\Exception\ResponseException;
use App\Builder\Http\Response;
use App\Validation\ValidationException;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        if ($_ENV['APP_ENV'] === 'dev') {
            return;
        }
        
        $e = $event->getThrowable();
        dd($e->getMessage().' File'.$e->getFile());
        $response = new Response();
        
        switch (get_class($e)) {
            case ResponseException::class:
                $response
                    ->setMessage($e->getMessage())
                    ->setStatusCode($e->getCode());
                break;
            case ValidationException::class:
                $response
                    ->setMessage($e->getMessage())
                    ->setErrors($e->getValidationMessages())
                    ->setStatusCode(500);
                break;
            case AuthenticationException::class|AccessDeniedException::class|AccessDeniedHttpException::class:
                $response
                    ->setMessage('Auth error. Invalid credentials.')
                    ->setStatusCode(403);
                break;
            default:
                $response
                    ->setMessage('Internal server error.')
                    ->setStatusCode(500);
                break;
        }
        
        $event->setResponse($response->error());
    }
    
    
}