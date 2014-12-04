@extends('layouts.default')
@section('content')
    <h2>View Report Grouping</h2>
    <hr>
    {{ Former::open() }}
        {{Former::populate($reportgrouping)}}
        @include('reportgroupings.form')
        @include('reportgroupings.actions-footer')
@stop