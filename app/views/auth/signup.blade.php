@extends('layouts.auth')
@section('content')
<h1>Signup</h1>
<hr>
<form method="POST" action="{{{ (Confide::checkAction('AuthController@store')) ?: URL::to('user')  }}}" accept-charset="UTF-8">
    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
    <fieldset>
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input required class="form-control" placeholder="John" type="text" name="first_name" id="first_name" value="{{{ Input::old('first_name') }}}">
        </div>
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input required class="form-control" placeholder="Doe" type="text" name="last_name" id="last_name" value="{{{ Input::old('last_name') }}}">
        </div>
        <div class="form-group">
            <label for="username">{{{ Lang::get('confide::confide.username') }}}</label>
            <input required class="form-control" placeholder="{{{ Lang::get('confide::confide.username') }}}" type="text" name="username" id="username" value="{{{ Input::old('username') }}}">
        </div>
        <div class="form-group">
            <label for="email">{{{ Lang::get('confide::confide.e_mail') }}} <small>{{ Lang::get('confide::confide.signup.confirmation_required') }}</small></label>
            <input required class="form-control" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
        </div>
        <div class="form-group">
            <label for="password">{{{ Lang::get('confide::confide.password') }}}</label>
            <input required class="form-control" placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password">
        </div>
        <div class="form-group">
            <label for="password_confirmation">{{{ Lang::get('confide::confide.password_confirmation') }}}</label>
            <input required class="form-control" placeholder="{{{ Lang::get('confide::confide.password_confirmation') }}}" type="password" name="password_confirmation" id="password_confirmation">
        </div>

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

        <div class="form-actions form-group">
          <button type="submit" class="btn btn-primary">{{{ Lang::get('confide::confide.signup.submit') }}}</button>
        </div>

    </fieldset>
</form>
<p class="text-center">
    {{link_to_action('AuthController@forgotPassword', 'Forgot Password')}} |
    {{link_to_action('AuthController@login', 'Login')}}
</p>
@stop
