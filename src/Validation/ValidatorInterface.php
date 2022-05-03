<?php

namespace App\Validation;

interface ValidatorInterface
{
    /**
     * @param object $object
     * @return bool
     */
    public function validate(object $object): bool;
}