@extends('layouts.default')
@section('content')
  <h2>Edit Upload</h2>
  <hr>
  {{ Former::open(action('uploads.update', $upload->id)) }}
    {{Former::populate($upload)}}
    {{Former::hidden('_method', 'PUT')}}
    @include('uploads.form')
    @include('uploads.actions-footer', ['has_submit' => true])
@stop