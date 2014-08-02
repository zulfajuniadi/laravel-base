@extends('layouts.default')
@section('content')
  <h2>New Upload</h2>
  <hr>
  {{ Former::open(action('uploads.store')) }}
    @include('uploads.form')
    @include('uploads.actions-footer', ['has_submit' => true])
@stop