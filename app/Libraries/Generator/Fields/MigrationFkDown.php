<?php

namespace App\Libraries\Generator\Fields;

class MigrationFkDown
{
    public function make($fields, $modelParams, $relationships)
    {
        $str = implode("\n", array_filter(array_map(function($params) use ($modelParams) {
            switch ($params[0]) {
                case 'belongsTo':
                case 'hasOne':
                    return "            \$table->dropForeign('{$modelParams['model_names']}_{$params[3]}_foreign');";
                    break;
                default:
                    break;
            }
        }, $relationships)));
        if(strlen($str))
            $str = "\n\n        Schema::table({$modelParams['model_names']}, function ($table) {\n" . $str . "});\n";
        return $str;
    }
}