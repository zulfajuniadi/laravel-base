@extends('layouts.default')
@section('content')
    <h2>Edit Report Eager</h2>
    <hr>
    {{ Former::open(action('ReportEagersController@update', [$report_id, $reporteager->id])) }}
        {{Former::populate($reporteager)}}
        {{Former::hidden('_method', 'PUT')}}
        @include('reporteagers.form')
        @include('reporteagers.actions-footer', ['has_submit' => true])
@stop