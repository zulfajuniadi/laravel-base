@extends('layouts.default')
@section('content')
    <h2>Edit Report Category</h2>
    <hr>
    {{ Former::open(action('ReportCategoriesController@update', $reportcategory->id)) }}
        {{Former::populate($reportcategory)}}
        {{Former::hidden('_method', 'PUT')}}
        @include('reportcategories.form')
        @include('reportcategories.actions-footer', ['has_submit' => true])
@stop