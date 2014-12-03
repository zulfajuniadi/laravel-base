
{{ Former::text('order')
    ->label('Order')
    ->required()
    ->value($report->nextFieldOrder()) }}
{{ Former::select('name')
    ->label('Field')
    ->options($report->availableFields())
    ->required() }}
{{ Former::text('label')
    ->label('Label')
    ->required() }}
{{ Former::select('type')
    ->label('Type')
    ->options($report->fieldTypes) 
    ->placeholder('Choose Type')
    ->required() }}
{{ Former::textarea('options')
    ->placeholder("OrganizationUnit::lists('id', 'name')")
    ->label('Options')}}
{{ Former::text('default')
    ->label('Default') }}
