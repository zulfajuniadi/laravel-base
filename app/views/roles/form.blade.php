{{Former::text('name')
  ->required()}}
{{Former::select('permissions')
  ->name('permissions[]')
  ->label('Permissions')
  ->required()
  ->options(Permission::all()->lists('display_name', 'id'))
  ->value(isset($role) ? $role->perms->lists('id') : [])
  ->multiple()}}