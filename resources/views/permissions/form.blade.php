{!! Former::select('permission_group_id')
    ->label('permissions.permission_group_id')
    ->options(App\PermissionGroup::options())
    ->required() !!}
{!! Former::text('name')
    ->label('permissions.name')
    ->required() !!}
{!! Former::text('display_name')
    ->label('permissions.display_name')
    ->required() !!}
