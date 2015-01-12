@extends('layouts.auth')
@section('content')
<div class="row">
    <div class="col-sm-6 col-sm-offset-3">
        <h1 class="text-center">{{trans('auth.forgot_password.title')}}</h1>
        <hr>
        @if ( Session::get('error') )
            <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
        @endif
        @if ( Session::get('notice') )
            <div class="alert alert-info">{{{ Session::get('notice') }}}</div>
        @endif
        {{Former::open_vertical(action('AuthController@doForgotPassword'))}}
            <div class="form-group">
                <div class="input-append input-group">
                    <input class="form-control" placeholder="{{trans('auth.register.email')}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
                    <span class="input-group-btn">
                        <input class="btn btn-primary" type="submit" value="{{trans('auth.forgot_password.continue')}}">
                    </span>
                </div>
            </div>
        {{Former::close()}}
        <p class="text-center">
            {{link_to_action('AuthController@login', trans('auth.login.title'))}} | 
            {{link_to_action('AuthController@create', trans('auth.register.title'))}}
        </p>
    </div>
@stop
