<?php

namespace App\Exceptions;

use Exception;

class RepositoryException extends Exception 
{

    private $context;

    public function getContext()
    {
        return $this->context;
    }

    public function __construct($operation, $context = [], $code = 0, Exception $previous = null)
    {
        $this->context = $context;
        parent::__construct('Error on repository opration: ' . $operation, $code, $previous);
    }
}