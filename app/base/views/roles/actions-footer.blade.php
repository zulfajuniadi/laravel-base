<div class="well">
    @if(isset($has_submit))
        <button class="btn btn-primary">Submit</button>
    @endif
    @if(!isset($is_list) && Role::canList())
        <a href="{{route('roles.index')}}" class="btn btn-default">List</a>
    @endif
    @if(Role::canCreate())
        <a href="{{route('roles.create')}}" class="btn btn-default">Create</a>
    @endif
    {{Former::close()}}
    @if(isset($role))
        @if($role->canShow())
            <a href="{{ action('roles.show', $role->id) }}" class="btn btn-default">Details</a>
        @endif
        @if($role->canUpdate())
            <a href="{{ action('roles.edit', $role->id) }}" class="btn btn-default">Edit</a>
        @endif
        @if($role->canDelete())
            {{Former::open(action('roles.destroy', $role->id))->class('form-inline')}}
                {{Former::hidden('_method', 'DELETE')}}
                <button type="button" class="btn btn-default confirm-delete">Delete</button>
            {{Former::close()}}
        @endif
    @endif
</div>
