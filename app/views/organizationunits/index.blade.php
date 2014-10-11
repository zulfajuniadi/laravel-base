@extends('layouts.default')
@section('content')
    <h2>Organization Units</h2>
    <hr>
    <table data-path="/organizationunits" class="DT table table-striped table-hover table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Parent</th>
                <th>Head</th>
                <th>Head Count</th>
                <th width="200px">Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <br>
    @include('organizationunits.actions-footer', ['is_list' => true])
@stop
