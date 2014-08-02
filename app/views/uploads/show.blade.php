@extends('layouts.default')
@section('content')
  <h2>View Upload</h2>
  <hr>
  {{ Former::open() }}
    {{Former::populate($upload)}}
    @include('uploads.form')
    @include('uploads.actions-footer')
@stop