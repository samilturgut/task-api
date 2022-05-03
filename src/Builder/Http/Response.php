<?php

namespace App\Builder\Http;

use Symfony\Component\HttpFoundation\JsonResponse;

class Response
{
    /**
     * @var array
     */
    private array $data = [];
    
    /**
     * @var int
     */
    private int $statusCode = 200;
    
    /**
     * @var array
     */
    private array $headers = [];
    
    /**
     * @var string|null
     */
    private string|null $message = null;
    
    /**
     * @var array
     */
    private array $errors = [];
    
    public function setData(array $data): static
    {
        $this->data = $data;
        
        return $this;
    }
    
    public function setStatusCode(int $statusCode): static
    {
        $this->statusCode = $statusCode;
        
        return $this;
    }
    
    public function setHeaders(array $headers): static
    {
        $this->headers = $headers;
        
        return $this;
    }
    
    public function setMessage(?string $message = null): static
    {
        $this->message = $message;
        
        return $this;
    }
    
    public function setErrors(array $errors): static
    {
        $this->errors = $errors;
        
        return $this;
    }
    
    public function ok(): JsonResponse
    {
        return new JsonResponse([
            'success' => true,
            'data' => $this->data,
        ], $this->statusCode, $this->headers);
    }
    
    public function error(): JsonResponse
    {
        return new JsonResponse([
            'success' => false,
            'errors' => $this->errors,
            'message' => $this->message,
        ], $this->statusCode, $this->headers);
    }
    
    public function __destruct()
    {
        $this->data = [];
        $this->headers = [];
        $this->message = null;
        $this->errors = [];
    }
}