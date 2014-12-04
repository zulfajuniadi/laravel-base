@extends('layouts.default')
@section('content')
    <h2>Report Filters</h2>
    <hr>
    <table data-path="{{action('ReportFieldsController@index', $report_id)}}" class="DT table table-striped table-hover table-bordered">
        <thead>
            <tr>
                <th>Order</th>
                <th>Name</th>
                <th>Label</th>
                <th>Type</th>
                <th>Options</th>
                <th>Default</th>
                <th width="200px">Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <br>
    @include('reportfields.actions-footer', ['is_list' => true])
@stop