@extends('layouts.default')
@section('content')
  <h2>View Organization Units</h2>
  <hr>
  {{ Former::open() }}
    {{Former::populate($organizationunit)}}
    @include('organizationunits.form')
    @include('organizationunits.actions-footer')
@stop