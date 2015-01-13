@extends('layouts.default')
@section('content')
    <h2>New Report Grouping</h2>
    <hr>
    {{ Former::open(action('ReportGroupingsController@store', $report_id)) }}
    @include('reportgroupings.form')
    @include('reportgroupings.actions-footer', ['has_submit' => true])
@stop