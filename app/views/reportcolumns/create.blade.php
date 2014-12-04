@extends('layouts.default')
@section('content')
    <h2>New Report Column</h2>
    <hr>
    {{ Former::open(action('ReportColumnsController@store', $report_id)) }}
    @include('reportcolumns.form')
    @include('reportcolumns.actions-footer', ['has_submit' => true])
@stop