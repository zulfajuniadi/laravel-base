@extends('layouts.default')
@section('content')
    <h2>Set {{$user->first_name}} {{$user->last_name}}'s Password</h2>
    <hr>
    {{ Former::open(action('UsersController@putSetPassword', $user->id)) }}
        {{Former::hidden('_method', 'PUT')}}
        {{Former::password('password')
            -> required() }}
        {{Former::password('password_confirmation')
            -> required() }}
        @include('users.actions-footer', ['has_submit' => true])
@stop
