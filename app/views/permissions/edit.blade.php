@extends('layouts.default')
@section('content')
    <h2>Edit Permission</h2>
    <hr>
    {{ Former::open(action('permissions.update', $permission->id)) }}
        {{Former::populate($permission)}}
        {{Former::hidden('_method', 'PUT')}}
        @include('permissions.form')
        @include('permissions.actions-footer', ['has_submit' => true])
@stop
