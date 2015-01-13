@extends('layouts.default')
@section('content')
    <h2>Roles</h2>
    <hr>
    <table data-path="/roles" class="DT table table-striped table-hover table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Assigned Permissions</th>
                <th>User Count</th>
                <th width="200px">Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <br>
    @include('roles.actions-footer', ['is_list' => true])
@stop
