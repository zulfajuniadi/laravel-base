
{{ Former::select('report_category_id')
    ->help('Report will be grouped under this category')
    ->placeholder('Choose One')
    ->options(ReportCategory::lists('name', 'id'))
    ->label('Category')
    ->required() }}
{{ Former::text('name')
    ->help('Report name will appear under "report" dropdown')
    ->label('Name')
    ->required() }}
{{ Former::text('model')
    ->help('Your eloquent model name e.g: User')
    ->label('Model')
    ->required() }}
{{ Former::text('path')
    ->help('Path which report will be accessed through e.g: user')
    ->label('Path')
    ->required() }}
{{ Former::radios('is_json')
    ->help('Report link will be hidden from report dropdown')
    ->label('Ajax Only')
    ->check([true, false])
    ->required()
    ->inline()
    ->radios(array(
        'Yes' => array('name' => 'is_json', 'value' => '1'),
        'No' => array('name' => 'is_json', 'value' => '0'),
    )) }}
