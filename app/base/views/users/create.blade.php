@extends('layouts.default')
@section('content')
    <h2>New User</h2>
    <hr>
    {{ Former::open(action('users.store')) }}
        @include('users.form')
        {{ Former::password('password')
            ->required() }}
        {{ Former::password('password_confirmation')
            ->required() }}
        @include('users.actions-footer', ['has_submit' => true])
@stop
