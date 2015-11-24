<?php

namespace App\Libraries\Generator\Fields;

class Show
{
    public function make($fields, $modelParams)
    {
        return implode("\n", array_map(function($params) use ($modelParams) {
            return "                        <dl class=\"col-md-6\">
                            <dt>{{trans('{$modelParams['model-names']}.{$params[0]}')}}</dt>
                            <dd>{{\${$modelParams['modelName']}->{$params[0]}}}</dd>
                        </dl>";
        }, $fields));
    }
}