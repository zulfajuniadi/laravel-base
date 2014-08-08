{{Former::text('name')
    ->required()}}
{{Former::text('group_name')
    ->label('Group Title')
    ->useDatalist(Permission::groupBy('group_name')->get(), 'group_name')
    ->required()}}
{{Former::text('display_name')
    ->label('Description')
    ->required()}}
