@extends('layouts.default')
@section('content')
    <h2>Edit Report</h2>
    <hr>
    {{ Former::open(action('ReportsController@update', $report->id)) }}
        {{Former::populate($report)}}
        {{Former::hidden('_method', 'PUT')}}
        @include('reports.form')
        @include('reports.actions-footer', ['has_submit' => true])
@stop