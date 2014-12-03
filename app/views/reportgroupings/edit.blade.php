@extends('layouts.default')
@section('content')
    <h2>Edit Report Grouping</h2>
    <hr>
    {{ Former::open(action('ReportGroupingsController@update', [$report_id, $reportgrouping->id])) }}
        {{Former::populate($reportgrouping)}}
        {{Former::hidden('_method', 'PUT')}}
        @include('reportgroupings.form')
        @include('reportgroupings.actions-footer', ['has_submit' => true])
@stop