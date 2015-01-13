@extends('layouts.default')
@section('content')
    <h2>Change Password</h2>
    <hr>
    {{ Former::open(action('UsersController@putChangePassword')) }}
        {{Former::hidden('_method', 'PUT')}}
        {{Former::password('old_password')
            -> required() }}
        {{Former::password('password')
            -> required() }}
        {{Former::password('password_confirmation')
            -> required() }}
        <div class="well">
            <button class="btn btn-primary">Submit</button>
            <a href="{{action('UsersController@profile')}}" class="btn btn-default">Back</a>
        </div>
    {{Former::close()}}
@stop
