<?php

namespace App\Libraries;

trait BootedTrait
{
    public function bootBootedTrait()
    {
        app('booted')->then(function() {
            $this->booted();
        });
    }
}