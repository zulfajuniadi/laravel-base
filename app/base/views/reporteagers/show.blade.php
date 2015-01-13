@extends('layouts.default')
@section('content')
    <h2>View Report Eager</h2>
    <hr>
    {{ Former::open() }}
        {{Former::populate($reporteager)}}
        @include('reporteagers.form')
        @include('reporteagers.actions-footer')
@stop