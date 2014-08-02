<?php $item = Permission::find($id); ?>
@if($item->canShow())
  <a href="{{ URL::route( 'permissions.show', array($id)) }}" class="btn btn-default">View</a>
@endif
@if($item->canUpdate())
  <a href="{{ URL::route( 'permissions.edit', array($id)) }}" class="btn btn-default">Edit</a>
@endif
@if($item->canDelete())
  {{Former::open(action('permissions.destroy', $item->id))->class('form-inline')}}
    {{Former::hidden('_method', 'DELETE')}}
    <button type="button" class="btn btn-default confirm-delete">Delete</button>
  {{Former::close()}}
@endif
