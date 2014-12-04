
{{ Former::text('order')
    ->label('Order')
    ->required()
    ->help('Order which the filter is shown')
    ->value($report->nextFieldOrder()) }}
{{ Former::select('name')
    ->label('Field')
    ->options($report->availableFields())
    ->help('Which db column it will search')
    ->required() }}
{{ Former::text('label')
    ->label('Label')
    ->help('Filter name')
    ->required() }}
{{ Former::select('type')
    ->label('Type')
    ->options($report->fieldTypes) 
    ->placeholder('Choose Type')
    ->help('Filter type')
    ->required() }}
{{ Former::textarea('options')
    ->placeholder("OrganizationUnit::lists('name', 'id')")
    ->help('Options for the filter (select, checkbox, radio)')
    ->label('Options')}}
{{ Former::text('default')
    ->help('Default value for the filter')
    ->label('Default') }}
