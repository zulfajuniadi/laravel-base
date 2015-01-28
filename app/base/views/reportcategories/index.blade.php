@extends('layouts.default')
@section('content')
    <h2>Report Categories</h2>
    <hr>
    <table data-path="{{action('ReportCategoriesController@index')}}" class="DT table table-striped table-hover table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th width="200px">Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <br>
    @include('reportcategories.actions-footer', ['is_list' => true])
@stop