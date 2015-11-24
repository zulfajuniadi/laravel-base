<?php

namespace App\Libraries\Generator\Fields;

class RevisionableName
{
    public function make($fields, $modelParams)
    {
        return implode("\n", array_map(function($params) use ($modelParams) {
            return "            '{$params[0]}'  => trans('{$modelParams['model-names']}.{$params[0]}'),";
        }, $fields));
    }
}