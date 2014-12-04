@extends('layouts.default')
@section('content')
    <h2>View Report Column</h2>
    <hr>
    {{ Former::open() }}
        {{Former::populate($reportcolumn)}}
        @include('reportcolumns.form')
        @include('reportcolumns.actions-footer')
@stop