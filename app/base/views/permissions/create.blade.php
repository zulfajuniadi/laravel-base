@extends('layouts.default')
@section('content')
    <h2>New Permission</h2>
    <hr>
    {{ Former::open(action('permissions.store')) }}
        @include('permissions.form')
        @include('permissions.actions-footer', ['has_submit' => true])
@stop
