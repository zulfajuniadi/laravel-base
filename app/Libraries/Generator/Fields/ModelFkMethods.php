<?php

namespace App\Libraries\Generator\Fields;

use Illuminate\Support\Str;

class ModelFkMethods
{
    public function make($fields, $modelParams, $relationships)
    {
        return implode("\n\n", array_map(function($params) use ($modelParams) {
            switch ($params[0]) {
                case 'belongsTo':
                    return "    public function " . Str::singular($params[2]) ."() {
        return \$this->belongsTo({$params[1]}::class, '{$params[3]}');
    }";
                    break;
                case 'hasOne':
                    return "    public function " . Str::singular($params[2]) ."() {
        return \$this->hasOne({$params[1]}::class, '{$params[3]}');
    }";
                    break;
                case 'hasMany':
                    return "    public function {$params[2]}() {
        return \$this->hasMany({$params[1]}::class);
    }";
                    break;
                case 'belongsToMany':
                    return "    public function {$params[2]}() {
        return \$this->belongsToMany({$params[1]}::class);
    }";
                    break;
                default:
                    break;
            }
        }, $relationships));
    }
}