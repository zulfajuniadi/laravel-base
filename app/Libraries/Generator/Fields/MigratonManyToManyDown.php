<?php

namespace App\Libraries\Generator\Fields;

class MigratonManyToManyDown
{
    public function make($fields, $modelParams, $relationships)
    {
        return implode("\n", array_filter(array_map(function($params) use ($modelParams) {
            if($params[0] == 'belongsToMany') {
                return "if(Schema::hasTable('{$params[3]}')) {
            Schema::table('{$params[3]}', function(\$table) {
                \$table->dropForeign('{$params[3]}_{$params[4]}_foreign');
            });
            try {
                Schema::drop('{$params[3]}');
            } catch (Exception \$e) {}
        }\n\n        ";
            }
        }, $relationships)));
    }
}