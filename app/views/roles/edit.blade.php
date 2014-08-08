@extends('layouts.default')
@section('content')
    <h2>Edit Role</h2>
    <hr>
    {{ Former::open(action('roles.update', $role->id)) }}
        {{Former::populate($role)}}
        {{Former::hidden('_method', 'PUT')}}
        @include('roles.form')
        @include('roles.actions-footer', ['has_submit' => true])
@stop
