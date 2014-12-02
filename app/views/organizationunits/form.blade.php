{{Former::text('name')
    ->required()}}
{{Former::select('parent_id')
    ->placeholder('Group Parent')
    ->label('Parent')
    ->options(OrganizationUnit::all()->lists('name', 'id')) }}
{{Former::select('user_id')
    ->label('Head')
    ->options(User::all()->lists('username', 'id'))
    ->required()}}
