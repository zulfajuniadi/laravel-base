@extends('layouts.default')
@section('content')
    <h2>Report Groupings</h2>
    <hr>
    <table data-path="{{action('ReportGroupingsController@index', $report_id)}}" class="DT table table-striped table-hover table-bordered">
        <thead>
            <tr>
                <th>Field</th>
                <th>Label</th>
                <th width="200px">Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <br>
    @include('reportgroupings.actions-footer', ['is_list' => true])
@stop