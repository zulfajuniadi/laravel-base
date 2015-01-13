@extends('layouts.default')
@section('content')
    <h2>Report Columns</h2>
    <hr>
    <table data-path="{{action('ReportColumnsController@index', $report_id)}}" class="DT table table-striped table-hover table-bordered">
        <thead>
            <tr>
                <th>Order</th>
                <th>Name</th>
                <th>Label</th>
                <th>Mappings</th>
                <th>Mutator</th>
                <th width="200px">Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <br>
    @include('reportcolumns.actions-footer', ['is_list' => true])
@stop