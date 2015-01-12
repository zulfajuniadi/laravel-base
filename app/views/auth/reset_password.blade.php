@extends('layouts.auth')
@section('content')
<div class="row">
    <div class="col-sm-6 col-sm-offset-3">
        <h1 class="text-center">{{trans('auth.reset_password.title')}}</h1>
        <hr>
        @if ( Session::get('error') )
            <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
        @endif
        @if ( Session::get('notice') )
            <div class="alert alert-info">{{{ Session::get('notice') }}}</div>
        @endif
        {{Former::open_vertical(action('AuthController@doResetPassword'))}}
            {{Former::hidden('token')->value($token)}}
            {{Former::password('password')
                ->label('auth.register.password')
                ->required()}}
            {{Former::password('confirm_password')
                ->label('auth.register.confirm_password')
                ->required()}}
            <div class="form-actions form-group">
                <button type="submit" class="btn btn-primary">{{trans('auth.reset_password.continue')}}</button>
            </div>
        {{Former::close()}}
    </div>
</div>
@stop
