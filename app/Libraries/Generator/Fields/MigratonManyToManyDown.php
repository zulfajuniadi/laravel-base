<?php

namespace App\Libraries\Generator\Fields;

class MigratonManyToManyDown
{
    public function make($fields, $modelParams, $relationships)
    {
        return implode("\n", array_filter(array_map(function($params) use ($modelParams) {
            if($params[0] == 'belongsToMany') {
                return "if(Schema::hasTable('{$params[3]}')) {
            try {
                Schema::table('{$params[3]}', function(\$table) {
                    \$table->dropForeign('{$params[3]}_{$params[4]}_foreign');
                    \$table->dropForeign('{$params[3]}_{$params[5]}_foreign');
                });
            } catch (Exception \$e) {}
            try {
                Schema::drop('{$params[3]}');
            } catch (Exception \$e) {}
        }\n\n        ";
            }
        }, $relationships)));
    }
}