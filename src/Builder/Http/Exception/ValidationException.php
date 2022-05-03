<?php

namespace App\Builder\Http\Exception;

class ValidationException extends \Exception
{
    private array $messages;
    
    public function __construct(array $messages, string $message = 'Validation failed')
    {
        parent::__construct($message);
        $this->messages = $messages;
    
    }
    
    public function getValidationMessages(): array
    {
        return $this->messages;
    }

}