<?php

namespace App\Libraries\Policy\Exceptions;

use Exception;

class PolicyDoesNotExists extends Exception {

    public function __construct($class, $code = 0, Exception $previous = null)
    {
        $this->message = 'Policy for class "' . $class . '" does not exists';
        parent::__construct($this->message, $code = 0, $previous);
    }

}