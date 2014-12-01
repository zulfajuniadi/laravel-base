<div class="well">
    @if(isset($has_submit))
        <button class="btn btn-primary">Submit</button>
    @endif
    @if(!isset($is_list) && User::canList())
        <a href="{{route('users.index')}}" class="btn btn-default">List</a>
    @endif
    @if(User::canCreate())
        <a href="{{route('users.create')}}" class="btn btn-default">Create</a>
    @endif
    {{Former::close()}}
    @if(isset($user))
        @if($user->canShow())
            <a href="{{ action('users.show', $user->id) }}" class="btn btn-default">Details</a>
        @endif
        @if($user->canUpdate())
            <a href="{{ action('users.edit', $user->id) }}" class="btn btn-default">Edit</a>
        @endif
        @if($user->canSetConfirmation())
            @if($user->confirmed !== 1)
                {{Former::open(action('UsersController@putSetConfirmation', $user->id))->class('form-inline')}}
                    {{Former::hidden('_method', 'PUT')}}
                    {{Former::hidden('confirmed', '1')}}
                    <button type="submit" class="btn btn-default">Activate</button>
                {{Former::close()}}
            @else
                {{Former::open(action('UsersController@putSetConfirmation', $user->id))->class('form-inline')}}
                    {{Former::hidden('_method', 'PUT')}}
                    {{Former::hidden('confirmed', '0')}}
                    <button type="submit" class="btn btn-default">Deactivate</button>
                {{Former::close()}}
            @endif
        @endif
        @if($user->canSetPassword())
            <a href="{{ action('UsersController@getSetPassword', $user->id) }}" class="btn btn-default">Set Password</a>
        @endif
        @if($user->canDelete())
            {{Former::open(action('users.destroy', $user->id))->class('form-inline')}}
                {{Former::hidden('_method', 'DELETE')}}
                <button type="button" class="btn btn-default confirm-delete">Delete</button>
            {{Former::close()}}
        @endif
    @endif
</div>
