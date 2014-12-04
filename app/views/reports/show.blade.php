@extends('layouts.default')
@section('content')
    <h2>View Report</h2>
    <hr>
    {{ Former::open() }}
        {{Former::populate($report)}}
        @include('reports.form')
        @include('reports.actions-footer')
@stop