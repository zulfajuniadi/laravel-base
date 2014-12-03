@extends('layouts.default')
@section('content')
    <h2>New Report</h2>
    <hr>
    {{ Former::open(action('ReportsController@store')) }}
    @include('reports.form')
    @include('reports.actions-footer', ['has_submit' => true])
@stop