<div class="well">
    @if(isset($has_submit))
        <button class="btn btn-primary">Submit</button>
    @endif
    @if(!isset($is_list) && OrganizationUnit::canList())
        <a href="{{route('organizationunits.index')}}" class="btn btn-default">List</a>
    @endif
    @if(OrganizationUnit::canCreate())
        <a href="{{route('organizationunits.create')}}" class="btn btn-default">Create</a>
    @endif
    {{Former::close()}}
    @if(isset($organizationunit))
        @if($organizationunit->canShow())
            <a href="{{ action('organizationunits.show', $organizationunit->id) }}" class="btn btn-default">Details</a>
        @endif
        @if($organizationunit->canUpdate())
            <a href="{{ action('organizationunits.edit', $organizationunit->id) }}" class="btn btn-default">Edit</a>
        @endif
        @if($organizationunit->canDelete())
            {{Former::open(action('organizationunits.destroy', $organizationunit->id))->class('form-inline')}}
                {{Former::hidden('_method', 'DELETE')}}
                <button type="button" class="btn btn-default confirm-delete">Delete</button>
            {{Former::close()}}
        @endif
    @endif
</div>
