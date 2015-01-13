{{Former::text('first_name')
    ->label('First Name')
    ->required()}}
{{Former::text('last_name')
    ->label('Last Name')
    ->required()}}
{{Former::text('username')
    ->label('Username')
    ->required()}}
{{Former::email('email')
    ->required()}}
{{Former::multiselect('roles')
    ->label('Roles')
    ->options(Role::all()->lists('name', 'id'), (isset($user) ? $user->roles->lists('id') : [])) }}
