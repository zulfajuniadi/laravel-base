
{{ Former::text('order')
    ->label('Order')
    ->required()
    ->help('Order which the column is shown')
    ->value($report->nextColumnOrder()) }}
{{ Former::select('name')
    ->label('Field')
    ->help('Which column is shown')
    ->options($report->availableFields())
    ->required() }}
{{ Former::text('label')
    ->label('Label')
    ->help('Column header')
    ->required() }}
{{ Former::textarea('options')
    ->label('Mappings')
    ->help('Array that maps the value')
    ->placeholder('["No", "Yes"]') }}
{{ Former::textarea('mutator')
    ->help('Mutator function to format the value')
    ->label('Mutator')
    ->placeholder("\$value->format('F j, Y')") }}
