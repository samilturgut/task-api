<?php

namespace App\Builder\Http;

use App\Builder\Http\Exception\RequestException;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class Request
{
    private SymfonyRequest $request;
    
    private array $parameters = [];
    
    private array $headers = [];
    
    public function __construct(SymfonyRequest $request)
    {
        $this->request = $request;
        
        if (str_starts_with($request->headers->get('Content-Type'), 'application/json')) {
            $parameters = json_decode($request->getContent(), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new RequestException('Invalid JSON');
            }
            $this->parameters = $parameters;
        } else {
            $this->parameters = $request->request->all();
        }
        
        $this->headers = $request->headers->all();
    }
    
    public function getParameters(): array
    {
        return $this->parameters;
    }
    
    public function getHeaders(): array
    {
        return $this->headers;
    }
    
    public function getParameter(string $key, ?string $default = '')
    {
        return $this->parameters[$key] ?? $default;
    }
    
    public function getRequest(): SymfonyRequest
    {
        return $this->request;
    }
    
    public function __destruct()
    {
        $this->parameters = [];
        $this->headers = [];
    }
}
