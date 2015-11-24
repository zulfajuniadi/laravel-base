<?php

namespace App\Libraries\Generator\Fields;

class Form
{
    public function make($fields, $modelParams)
    {
        return array_reduce($fields, function($carry, $params) use ($modelParams) {
            $field = '';
            if(!isset($params[2]))
                $params[2] = 'string';
            switch ($params[2]) {
                case 'text':
                case 'mediumText':
                case 'longText':
                    $field .= '{!! Former::textarea(\'' . $params[0] . '\')
    ->label(\'' . $modelParams['model-names'] . '.' . $params[0] . '\')
    ->rows(4)
    ->required() !!}';
                    break;
                case 'boolean':
                    $field .= '{!! Former::stacked_radios(\'' . $params[0] . '\')
    ->label(\'' . $modelParams['model-names'] . '.' . $params[0] . '\')
    ->radios(\'False\', \'True\')
    ->check(0)
    ->required() !!}';
                    break;
                case 'integer':
                case 'tinyInteger':
                case 'smallInteger':
                case 'mediumInteger':
                case 'bigInteger':
                    if(isset($params[3])) {
                        $field .= '{!! Former::select(\'' . $params[0] . '\')
    ->label(\'' . $modelParams['model-names'] . '.' . $params[0] . '\')
    ->options(App\\' . $params[3] . '::options())
    ->required() !!}';
                    } else {
                        $field .= '{!! Former::number(\'' . $params[0] . '\')
    ->label(\'' . $modelParams['model-names'] . '.' . $params[0] . '\')
    ->required() !!}';
                    }
                    break;
                case 'enum':
                    $options = [];
                    if(!isset($params[3]))
                        $params[3] = '';
                    $optionsParts = explode(',', $params[3]);
                    foreach ($optionsParts as $value) {
                        $options[$value] = $value;
                    }
                    $field .= '{!! Former::select(\'' . $params[0] . '\')
    ->label(\'' . $modelParams['model-names'] . '.' . $params[0] . '\')
    ->options(' . var_export($options, true) . ')
    ->required() !!}';
                    break;
                case 'dateTime':
                    $field .= '{!! Former::datetime(\'' . $params[0] . '\')
    ->label(\'' . $modelParams['model-names'] . '.' . $params[0] . '\')
    ->addClass(\'has-datetime\')
    ->required() !!}';
                    break;
                case 'date':
                    $field .= '{!! Former::date(\'' . $params[0] . '\')
    ->label(\'' . $modelParams['model-names'] . '.' . $params[0] . '\')
    ->addClass(\'has-date\')
    ->required() !!}';
                    break;
                case 'time':
                    $field .= '{!! Former::time(\'' . $params[0] . '\')
    ->label(\'' . $modelParams['model-names'] . '.' . $params[0] . '\')
    ->addClass(\'has-time\')
    ->required() !!}';
                    break;
                case 'string':
                default:
                    $field .= '{!! Former::text(\'' . $params[0] . '\')
    ->label(\'' . $modelParams['model-names'] . '.' . $params[0] . '\')
    ->required() !!}';
                    break;
            }
            return $carry . $field . "\n";
        }, '');
    }
}