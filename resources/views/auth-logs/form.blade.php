{!! Former::select('user_id')
    ->label('auth-logs.user_id')
    ->options(App\User::options())
    ->required() !!}
{!! Former::text('ip_address')
    ->label('auth-logs.ip_address')
    ->required() !!}
{!! Former::text('action')
    ->label('auth-logs.action')
    ->required() !!}
