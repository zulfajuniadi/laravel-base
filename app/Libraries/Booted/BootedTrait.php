<?php

namespace App\Libraries\Booted;

trait BootedTrait
{
    public function bootBootedTrait()
    {
        app('booted')->then(function() {
            $this->booted();
        });
    }
}