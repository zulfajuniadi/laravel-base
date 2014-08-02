@extends('layouts.default')
@section('content')
  <h2>Uploads</h2>
  <hr>
  <table data-path="/uploads" class="DT table table-striped table-hover table-bordered">
    <thead>
      <tr>
        
        <th>File Name</th>
        <th>File Size</th>
        <th>URL</th>
        <th>Path</th>
        <th>File Type</th>

        <th width="200px">Actions</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
  <br>
  @include('uploads.actions-footer', ['is_list' => true])
@stop