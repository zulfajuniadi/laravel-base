@extends('layouts.default')
@section('content')
    <h2>View Report Filter</h2>
    <hr>
    {{ Former::open() }}
        {{Former::populate($reportfield)}}
        @include('reportfields.form')
        @include('reportfields.actions-footer')
@stop