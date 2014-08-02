<div class="well">
  @if(isset($has_submit))
    <button class="btn btn-primary">Submit</button>
  @endif
  @if(!isset($is_list) && Upload::canList())
    <a href="{{route('uploads.index')}}" class="btn btn-default">List</a>  
  @endif
  @if(Upload::canCreate())
    <a href="{{route('uploads.create')}}" class="btn btn-default">Create</a>
  @endif
  {{Former::close()}}
  @if(isset($upload))
    @if($upload->canShow())
      <a href="{{ action('uploads.show', $upload->id) }}" class="btn btn-default">Details</a>
    @endif
    @if($upload->canUpdate())
      <a href="{{ action('uploads.edit', $upload->id) }}" class="btn btn-default">Edit</a>
    @endif
    @if($upload->canDelete())
      {{Former::open(action('uploads.destroy', $upload->id))->class('form-inline')}}
        {{Former::hidden('_method', 'DELETE')}}
        <button type="button" class="btn btn-default confirm-delete">Delete</button>
      {{Former::close()}}
    @endif
  @endif
</div>