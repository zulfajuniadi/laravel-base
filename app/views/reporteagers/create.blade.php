@extends('layouts.default')
@section('content')
    <h2>New Report Eager</h2>
    <hr>
    {{ Former::open(action('ReportEagersController@store', $report_id)) }}
    @include('reporteagers.form')
    @include('reporteagers.actions-footer', ['has_submit' => true])
@stop