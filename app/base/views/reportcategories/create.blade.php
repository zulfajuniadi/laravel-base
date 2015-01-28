@extends('layouts.default')
@section('content')
    <h2>New Report Category</h2>
    <hr>
    {{ Former::open(action('ReportCategoriesController@store')) }}
    @include('reportcategories.form')
    @include('reportcategories.actions-footer', ['has_submit' => true])
@stop