@extends('layouts.default')
@section('content')
    <h2>Edit Report Filter</h2>
    <hr>
    {{ Former::open(action('ReportFieldsController@update',[$report_id, $reportfield->id])) }}
        {{Former::populate($reportfield)}}
        {{Former::hidden('_method', 'PUT')}}
        @include('reportfields.form')
        @include('reportfields.actions-footer', ['has_submit' => true])
@stop