@if($role = Role::find($id))@endif
@if($role->canShow())
    <a href="{{ URL::route( 'roles.show', array($id)) }}" class="btn btn-default">View</a>
@endif
@if($role->canUpdate())
    <a href="{{ URL::route( 'roles.edit', array($id)) }}" class="btn btn-default">Edit</a>
@endif
@if($role->canDelete())
    {{Former::open(action('roles.destroy', $role->id))->class('form-inline')}}
        {{Former::hidden('_method', 'DELETE')}}
        <button type="button" class="btn btn-default confirm-delete">Delete</button>
    {{Former::close()}}
@endif
