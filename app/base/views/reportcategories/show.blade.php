@extends('layouts.default')
@section('content')
    <h2>View Report Category</h2>
    <hr>
    {{ Former::open() }}
        {{Former::populate($reportcategory)}}
        @include('reportcategories.form')
        @include('reportcategories.actions-footer')
@stop