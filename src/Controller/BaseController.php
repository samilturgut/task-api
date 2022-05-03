<?php

namespace App\Controller;

use App\Builder\Http\Response;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class BaseController extends AbstractController
{
    private Response $response;
    protected LoggerInterface $logger;
    
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->response = new Response();
    }
    
    public function _success(array $data, ?int $code = 200, ?array $headers = []): JsonResponse
    {
        return $this->response
            ->setData($data)
            ->setHeaders($headers)
            ->setStatusCode($code)
            ->ok();
    }
    
    public function _error(string $message, ?array $data = [], int $code = 500, ?array $headers = []): JsonResponse
    {
        return $this->response
            ->setErrors($data)
            ->setMessage($message)
            ->setHeaders($headers)
            ->setStatusCode($code)
            ->ok();
    }
}