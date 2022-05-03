<?php

namespace App\Validation;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class Validator implements \App\Validation\ValidatorInterface
{
    private ValidatorInterface $validator;
    
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }
    
    public function validate(object $object): bool
    {
        $errors = $this->validator->validate($object);
        if (count($errors) > 0) {
            $messages = [];
            foreach ($errors as $error) {
                $messages[] = ['key' => $error->getPropertyPath(), 'message' => $error->getMessage()];
            }
            
            throw new ValidationException($messages);
        }
        return true;
    }

}