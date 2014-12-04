
{{ Former::select('name')
    ->label('Field')
    ->help('Which field to enable grouping with')
    ->options($report->availableFields(false))
    ->required() }}
{{ Former::text('label')
    ->help('Field label')
    ->label('Label')
    ->required() }}
{{ Former::hidden('title_function')
    ->value('') }}
{{ Former::select('sql_function')
    ->help('SQL aggregation function')
    ->placeholder('Choose One')
    ->options(ReportGrouping::$sqlFunctions)
    ->label('SQL Aggregate') }}
