<?php

namespace App\Libraries\Generator\Fields;

class Index
{
    public function make($fields, $modelParams)
    {
        return implode("\n", array_map(function($params) use ($modelParams) {
            return "            ->addColumn(['data' => '{$params[0]}', 'name' => '{$params[0]}', 'title' => trans('{$modelParams['model-names']}.{$params[0]}')])";
        }, $fields));
    }
}