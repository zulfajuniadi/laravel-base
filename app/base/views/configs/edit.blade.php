@extends('layouts.default')
@section('content')
    <h2>Edit Config: {{$meta['config_title']}}</h2>
    <hr>
    {{ Former::open(action('ConfigsController@postEdit', $type)) }}
        @include('configs.form')
        @include('configs.actions-footer', ['has_submit' => true])
@stop