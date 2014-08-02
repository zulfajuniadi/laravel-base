@extends('layouts.default')
@section('content')
  <h2>My Profile</h2>
  <hr>


  <div class="well">
    <a href="{{action('UsersController@getChangePassword')}}" class="btn btn-default">Change My Password</a>
  </div>
@stop
@section('scripts')
@stop
@section('styles')
@stop