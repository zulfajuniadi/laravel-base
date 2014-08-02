@extends('layouts.default')
@section('content')
  <h2>View Permission</h2>
  <hr>
  {{ Former::open() }}
    {{Former::populate($permission)}}
    @include('permissions.form')
    @include('permissions.actions-footer')
@stop
@section('scripts')
  <script>
    $('input:not([type=hidden]),select,textarea', 'form').attr({
      disabled: true,
      readonly: true
    })
  </script>
@stop
@section('styles')
@stop