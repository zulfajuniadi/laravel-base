{{Former::text('name')
    ->required()}}
{{Former::select('parent_id')
    ->label('Parent')
    ->options(OrganizationUnit::all()->lists('name', 'id'))
    ->required()}}
{{Former::select('user_id')
    ->label('Head')
    ->options(User::all()->lists('username', 'id'))
    ->required()}}
