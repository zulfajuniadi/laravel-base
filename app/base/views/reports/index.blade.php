@extends('layouts.default')
@section('content')
    <h2>Reports</h2>
    <hr>
    <table data-path="{{action('ReportsController@index')}}" class="DT table table-striped table-hover table-bordered">
        <thead>
            <tr>
                <th>Category</th>
                <th>Name</th>
                <th>Model</th>
                <th>Path</th>
                <th>Hide Menu</th>
                <th width="200px">Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <br>
    @include('reports.actions-footer', ['is_list' => true])
@stop