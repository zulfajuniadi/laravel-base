{{Former::text('name')
  ->required()}}
{{Former::select('role.perms')
  ->name('permissions[]')
  ->label('Permissions')
  ->options(Permission::all()->lists('display_name', 'id'))
  ->value(isset($role) ? $role->perms->lists('id') : [])
  ->multiple()}}