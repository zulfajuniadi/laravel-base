@extends('layouts.auth')
@section('content')
<div class="row">
    <div class="col-sm-6 col-sm-offset-3">
        <h1>{{trans('auth.login.title')}}</h1>
        <hr>
        @if ( Session::get('error') )
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        @if ( Session::get('notice') )
            <div class="alert alert-info">{{ Session::get('notice') }}</div>
        @endif
        {{Former::open_vertical(action('AuthController@doLogin'))}}
                {{Former::text('email')
                    ->label('auth.login.username_or_email')
                    ->required()}}
                {{Former::password('password')
                    ->label('auth.login.password')
                    ->required()}}
                {{Former::hidden('remember')
                    ->value(0)}}
                {{Former::checkbox('remember')
                    ->label('')
                    ->text('auth.login.remember_me')}}
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{trans('auth.login.title')}}</button>
                    <a class="btn btn-success" href="{{action('AuthController@create')}}">{{trans('auth.register.title')}}</a>
                </div>
        {{Former::close()}}
        <p class="text-center">
            {{link_to_action('AuthController@forgotPassword', trans('auth.forgot_password.title'))}}
        </p>
    </div>
</div>
@stop
