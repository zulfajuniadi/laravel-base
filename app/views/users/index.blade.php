@extends('layouts.default')
@section('content')
    <h2>Users</h2>
    <hr>
    <table data-path="{{route('users.index')}}" class="DT table table-striped table-hover table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Roles</th>
                <th>Status</th>
                <th width="200px">Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <br>
    @include('users.actions-footer', ['is_list' => true])
@stop
