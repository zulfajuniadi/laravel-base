@extends('layouts.auth')
@section('content')
<div class="row">
    <div class="col-sm-8 col-sm-offset-2">
        <h1>{{trans('auth.register.title')}}</h1>
        <hr>
        @if ( Session::get('error') )
            <div class="alert alert-danger">
                @if ( is_array(Session::get('error')) )
                    {{ head(Session::get('error')) }}
                @endif
            </div>
        @endif
        @if ( Session::get('notice') )
            <div class="alert alert-info">{{ Session::get('notice') }}</div>
        @endif
        {{Former::open_vertical(action('AuthController@store'))}}
            <div class="row">
                <div class="col-sm-6">
                    {{Former::text('first_name')
                        ->label('auth.register.first_name')
                        ->required()}}
                    {{Former::text('last_name')
                        ->label('auth.register.last_name')
                        ->required()}}
                    {{Former::text('username')
                        ->label('auth.register.username')
                        ->required()}}
                </div>
                <div class="col-sm-6">
                    {{Former::email('email')
                        ->label('auth.register.email')
                        ->required()}}
                    {{Former::password('password')
                        ->label('auth.register.password')
                        ->required()}}
                    {{Former::password('password_confirmation')
                        ->label('auth.register.confirm_password')
                        ->required()}}
                </div>
            </div>
            <div class="form-actions form-group">
              <button type="submit" class="btn btn-primary">{{trans('auth.register.create_new_account')}}</button>
            </div>
        {{Former::close()}}
        <p class="text-center">
            {{link_to_action('AuthController@forgotPassword', trans('auth.forgot_password.title'))}} |
            {{link_to_action('AuthController@login', trans('auth.login.title'))}}
        </p>  
    </div>
</div>
@stop
