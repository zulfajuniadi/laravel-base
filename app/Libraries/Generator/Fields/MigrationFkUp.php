<?php

namespace App\Libraries\Generator\Fields;

class MigrationFkUp
{
    public function make($fields, $modelParams, $relationships)
    {
        $str = implode("\n", array_filter(array_map(function($params) use ($modelParams) {
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
        }, $relationships)));
        if(strlen($str))
            $str = "\n\n        Schema::table({$modelParams['model_names']}, function (\$table) {\n" . $str . "\n        });\n";
        return $str;
    }
}