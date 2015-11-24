<?php

namespace App\Libraries\Generator\Fields;

class Lang
{
    public function make($fields, $modelParams)
    {
        return implode("\n", array_map(function($params) use ($modelParams) {
            return "    '{$params[0]}' => '{$params[1]}',";
        }, $fields));
    }
}