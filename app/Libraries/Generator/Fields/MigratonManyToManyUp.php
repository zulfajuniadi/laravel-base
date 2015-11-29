<?php

namespace App\Libraries\Generator\Fields;

class MigratonManyToManyUp
{
    public function make($fields, $modelParams, $relationships)
    {
        return implode("\n", array_filter(array_map(function($params) use ($modelParams) {
            if($params[0] == 'belongsToMany') {
                return "\n\n        if(!Schema::hasTable('{$params[3]}')) {
            Schema::create('{$params[3]}', function(\$table) {
                \$table->increments('id');
                \$table->integer('{$params[4]}')->unsigned();
                \$table->integer('{$params[5]}')->unsigned();
                \$table->timestamps();
            });
        }

        try {
            Schema::table('{$params[3]}', function(\$table) {
                \$table->foreign('{$params[4]}')
                    ->references('id')
                    ->on('{$modelParams['model_names']}')
                    ->onDelete('cascade');
                \$table->foreign('{$params[5]}')
                    ->references('id')
                    ->on('{$params[2]}')
                    ->onDelete('cascade');
            });
        } catch (Exception \$e) {}";
            }
        }, $relationships)));
    }
}