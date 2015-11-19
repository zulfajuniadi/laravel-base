<?php

namespace App\Exceptions;

use Exception;

class PolicyMethodDoesNotExists extends Exception {

    public function __construct($class, $method, $code = 0, Exception $previous = null)
    {
        $this->message = 'Policy "' . $method . '" does not exists in class "' . $class . '"';
        parent::__construct($this->message, $code = 0, $previous);
    }

}