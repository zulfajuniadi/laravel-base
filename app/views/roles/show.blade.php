@extends('layouts.default')
@section('content')
    <h2>View Role</h2>
    <hr>
    {{ Former::open() }}
        {{Former::populate($role)}}
        @include('roles.form')
        @include('roles.actions-footer')
@stop
