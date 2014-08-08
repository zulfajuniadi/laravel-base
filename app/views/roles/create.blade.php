@extends('layouts.default')
@section('content')
    <h2>New Role</h2>
    <hr>
    {{ Former::open(action('roles.store')) }}
        @include('roles.form')
        @include('roles.actions-footer', ['has_submit' => true])
@stop
