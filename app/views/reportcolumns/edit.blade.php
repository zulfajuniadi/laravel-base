@extends('layouts.default')
@section('content')
    <h2>Edit Report Column</h2>
    <hr>
    {{ Former::open(action('ReportColumnsController@update', [$report_id, $reportcolumn->id])) }}
        {{Former::populate($reportcolumn)}}
        {{Former::hidden('_method', 'PUT')}}
        @include('reportcolumns.form')
        @include('reportcolumns.actions-footer', ['has_submit' => true])
@stop