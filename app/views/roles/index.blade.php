@extends('layouts.default')
@section('content')
  <h2>Roles</h2>
  <hr>
  <table class="DT">
    <thead>
      <tr>
        <th>Name</th>
        <th>Permissions</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
  <br>
  @include('roles.actions-footer', ['is_list' => true])
@stop
@section('scripts')
  <script src="{{asset('/assets/datatables/media/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('/assets/datatables-bootstrap/dist/dataTables.bootstrap.js')}}"></script>
  <script>
    $('.DT').each(function(){
      var target = $(this);
      var DT = target.DataTable({
        ajax: '/roles'
      });
    });
  </script>
@stop
@section('styles')
  <link rel="stylesheet" href="{{asset('/assets/datatables/media/css/jquery.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{asset('/assets/datatables-bootstrap/dist/dataTables.bootstrap.css')}}">
@stop