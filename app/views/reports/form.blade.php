
{{ Former::text('name')
    ->label('Name')
    ->required() }}
{{ Former::text('model')
    ->label('Model')
    ->required() }}
{{ Former::text('path')
    ->label('Path')
    ->required() }}
{{ Former::radios('is_json')
    ->label('Ajax Only')
    ->check([true, false])
    ->required()
    ->inline()
    ->radios(array(
        'Yes' => array('name' => 'is_json', 'value' => '1'),
        'No' => array('name' => 'is_json', 'value' => '0'),
    )) }}
