@extends('layouts.default')
@section('content')
    <h2>View Permission</h2>
    <hr>
    {{ Former::open() }}
        {{Former::populate($permission)}}
        @include('permissions.form')
        @include('permissions.actions-footer')
@stop
