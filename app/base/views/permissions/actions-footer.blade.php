<div class="well">
    @if(isset($has_submit))
        <button class="btn btn-primary">Submit</button>
    @endif
    @if(!isset($is_list) && Permission::canList())
        <a href="{{route('permissions.index')}}" class="btn btn-default">List</a>
    @endif
    @if(Permission::canCreate())
        <a href="{{route('permissions.create')}}" class="btn btn-default">Create</a>
    @endif
    {{Former::close()}}
    @if(isset($permission))
        @if($permission->canShow())
            <a href="{{ action('permissions.show', $permission->id) }}" class="btn btn-default">Details</a>
        @endif
        @if($permission->canUpdate())
            <a href="{{ action('permissions.edit', $permission->id) }}" class="btn btn-default">Edit</a>
        @endif
        @if($permission->canDelete())
            {{Former::open(action('permissions.destroy', $permission->id))->class('form-inline')}}
                {{Former::hidden('_method', 'DELETE')}}
                <button type="button" class="btn btn-default confirm-delete">Delete</button>
            {{Former::close()}}
        @endif
    @endif
</div>
