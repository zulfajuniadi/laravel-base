@extends('layouts.default')
@section('content')
  <h2>Edit User</h2>
  <hr>
  {{ Former::open(action('users.update', $user->id)) }}
    {{Former::populate($user)}}
    {{Former::hidden('_method', 'PUT')}}
    @include('users.form')
    @include('users.actions-footer', ['has_submit' => true])
@stop
@section('scripts')
@stop
@section('styles')
@stop