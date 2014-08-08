@if($user = User::find($id))@endif
@if($user->canShow())
    <a href="{{ URL::route( 'users.show', array($id)) }}" class="btn btn-default">View</a>
@endif
@if($user->canUpdate())
    <a href="{{ URL::route( 'users.edit', array($id)) }}" class="btn btn-default">Edit</a>
@endif
@if($user->canDelete())
    {{Former::open(action('users.destroy', $user->id))->class('form-inline')}}
        {{Former::hidden('_method', 'DELETE')}}
        <button type="button" class="btn btn-default confirm-delete">Delete</button>
    {{Former::close()}}
@endif
