@if($permission = Permission::find($id))@endif
@if($permission->canShow())
    <a href="{{ URL::route( 'permissions.show', array($id)) }}" class="btn btn-default">View</a>
@endif
@if($permission->canUpdate())
    <a href="{{ URL::route( 'permissions.edit', array($id)) }}" class="btn btn-default">Edit</a>
@endif
@if($permission->canDelete())
    {{Former::open(action('permissions.destroy', $permission->id))->class('form-inline')}}
        {{Former::hidden('_method', 'DELETE')}}
        <button type="button" class="btn btn-default confirm-delete">Delete</button>
    {{Former::close()}}
@endif
