{{Former::text('name')
  ->required()}}
{{Former::hidden('permissions[]', '')}}
{{Former::select('permissions')
  ->name('permissions[]')
  ->label('Permissions')
  ->options(Permission::all()->lists('display_name', 'id'))
  ->value(isset($role) ? $role->perms->lists('id') : [])
  ->multiple()}}