
{{ Former::text('order')
    ->label('Order')
    ->required()
    ->value($report->nextColumnOrder()) }}
{{ Former::select('name')
    ->label('Field')
    ->options($report->availableFields())
    ->required() }}
{{ Former::text('label')
    ->label('Label')
    ->required() }}
{{ Former::textarea('options')
    ->label('Mappings')
    ->placeholder('["No", "Yes"]') }}
{{ Former::textarea('mutator')
    ->label('Mutator')
    ->placeholder(" date('F j, Y', \$value)") }}
