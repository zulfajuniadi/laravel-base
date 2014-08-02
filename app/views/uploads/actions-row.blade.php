<?php $upload = Upload::find($id); ?>
@if($upload->canShow())
  <a href="{{ URL::route( 'uploads.show', array($id)) }}" class="btn btn-default">View</a>
@endif
@if($upload->canUpdate())
  <a href="{{ URL::route( 'uploads.edit', array($id)) }}" class="btn btn-default">Edit</a>
@endif
@if($upload->canDelete())
  {{Former::open(action('uploads.destroy', $upload->id))->class('form-inline')}}
    {{Former::hidden('_method', 'DELETE')}}
    <button type="button" class="btn btn-default confirm-delete">Delete</button>
  {{Former::close()}}
@endif
