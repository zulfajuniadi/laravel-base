{{Former::text('username')
  ->required()}}
{{Former::email('email')
  ->required()}}
{{Former::select('organizationunit_id')
  ->label('Organization Unit')
  ->options(OrganizationUnit::all()->lists('name', 'id'))
  ->required()}}
{{Former::select('user.roles')
  ->name('roles[]')
  ->label('Roles')
  ->options(Role::all()->lists('name', 'id'))
  ->value(isset($user) ? $user->roles->lists('id') : [])
  ->multiple()}}