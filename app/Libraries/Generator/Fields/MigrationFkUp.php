<?php

namespace App\Libraries\Generator\Fields;

class MigrationFkUp
{
    public function make($fields, $modelParams, $relationships)
    {
        return implode("\n", array_filter(array_map(function($params) use ($modelParams) {
            switch ($params[0]) {
                case 'belongsTo':
                case 'hasOne':
                    return "            \$table->foreign('{$params[3]}')
                ->references('id')
                ->on('{$params[2]}')
                ->onDelete('cascade');";
                    break;
                default:
                    break;
            }
            if(in_array($params[0], ['belongsTo', 'hasOne'])) {
            }
        }, $relationships)));
    }
}