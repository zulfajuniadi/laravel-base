@if($organizationunit = OrganizationUnit::find($id))@endif
@if($organizationunit->canShow())
    <a href="{{ URL::route( 'organizationunits.show', array($id)) }}" class="btn btn-default">View</a>
@endif
@if($organizationunit->canUpdate())
    <a href="{{ URL::route( 'organizationunits.edit', array($id)) }}" class="btn btn-default">Edit</a>
@endif
@if($organizationunit->canDelete())
    {{Former::open(action('organizationunits.destroy', $organizationunit->id))->class('form-inline')}}
        {{Former::hidden('_method', 'DELETE')}}
        <button type="button" class="btn btn-default confirm-delete">Delete</button>
    {{Former::close()}}
@endif
