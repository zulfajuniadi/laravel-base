@extends('layouts.default')
@section('content')
    <h2>View Config: {{$meta['config_title']}}</h2>
    <hr>
    {{ Former::open() }}
        <?php $show = true; ?>
        @include('configs.form')
        @include('configs.actions-footer')
@stop
