
{{ Former::select('name')
    ->label('Field')
    ->options($report->availableFields(false))
    ->required() }}
{{ Former::text('label')
    ->label('Label')
    ->required() }}
{{ Former::textarea('title_function')
    ->label('Title Function') }}
{{ Former::select('sql_function')
    ->placeholder('Choose One')
    ->options(ReportGrouping::$sqlFunctions)
    ->label('SQL Aggregate') }}
