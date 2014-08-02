@extends('layouts.default')
@section('content')
  <h2>
    @if($user->confirmed === 'Active')
      <span class="pull-right label label-lg label-success">
    @else
      <span class="pull-right label label-lg label-warning">
    @endif
    {{$user->confirmed}}</span>
    View User
  </h2>
  <hr>
  {{ Former::open() }}
    {{Former::populate($user)}}
    @include('users.form')
    @include('users.actions-footer')
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