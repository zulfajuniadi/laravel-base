<?php

namespace App\Libraries\Generator\Fields;

class Migration
{
    public function make($fields, $modelParams, $relationships)
    {
        return implode("\n", array_map(function($params) use ($modelParams, $relationships) {
            // if relationships set unsigned
            foreach ($relationships as $values) {
                if(in_array($values[0], ['belongsTo', 'hasOne']) && $values[3] == $params[0])
                    return "            \$table->{$params[2]}('{$params[0]}')->unsigned();";
            }
            return "            \$table->{$params[2]}('{$params[0]}');";
        }, $fields));
    }
}