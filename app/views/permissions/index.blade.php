@extends('layouts.default')
@section('content')
<h2>Permissions</h2>
<hr>
<table data-path="/permissions" class="DT table table-striped table-hover table-bordered">
    <thead>
        <tr>
            <th>Group</th>
            <th>Name</th>
            <th>Description</th>
            <th width="200px">Actions</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
<br>
@include('permissions.actions-footer', ['is_list' => true])
@stop
