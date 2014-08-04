{{Former::text('name')
  ->required()}}
{{ Former::select('perms[]')
  ->label('Permissions')
  ->multiple()
  ->options(Permission::all()->lists('display_name', 'id'), (isset($role) ? $role->perms->lists('id') : [])) }}
