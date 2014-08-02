@extends('layouts.default')
@section('content')
  <h2>View Organization Units</h2>
  <hr>
  {{ Former::open() }}
    {{Former::populate($organizationunit)}}
    @include('organizationunits.form')
    @include('organizationunits.actions-footer')
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