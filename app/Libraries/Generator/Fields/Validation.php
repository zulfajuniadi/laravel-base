<?php

namespace App\Libraries\Generator\Fields;

class Validation
{
    public function make($fields, $modelParams)
    {
        return implode("\n", array_map(function($params) use ($modelParams) {
            return "            '{$params[0]}' => 'required',";
        }, $fields));
    }
}