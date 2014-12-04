@extends('layouts.default')
@section('content')
    <h2>New Report Filter</h2>
    <hr>
    {{ Former::open(action('ReportFieldsController@store', $report_id)) }}
    @include('reportfields.form')
    @include('reportfields.actions-footer', ['has_submit' => true])
@stop