{{Former::text('name')
  ->required()}}
{{ Former::multiselect('perms')
  ->label('Permissions')
  ->options(Permission::all()->lists('display_name', 'id'), (isset($role) ? $role->perms->lists('id') : [])) }}
