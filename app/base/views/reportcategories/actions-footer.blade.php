<div class="well">
    @if(isset($has_submit))
        <button class="btn btn-primary">Submit</button>
    @endif
    @if(!isset($is_list) && ReportColumn::canList())
        <a href="{{action('ReportCategoriesController@index')}}" class="btn btn-default">List</a>  
    @endif
    @if(ReportColumn::canCreate())
        <a href="{{action('ReportCategoriesController@create')}}" class="btn btn-default">Create</a>
    @endif
    {{Former::close()}}
    @if(isset($reportcolumn))
        @if($reportcolumn->canShow())
          <a href="{{ action('ReportCategoriesController@show', $reportcategory->id) }}" class="btn btn-default">Details</a>
        @endif
        @if($reportcolumn->canUpdate())
          <a href="{{ action('ReportCategoriesController@edit', $reportcategory->id) }}" class="btn btn-default">Edit</a>
        @endif
        @if($reportcolumn->canDelete())
          {{Former::open(action('ReportCategoriesController@destroy', $reportcategory->id))->class('form-inline')}}
            {{Former::hidden('_method', 'DELETE')}}
            <button type="button" class="btn btn-default confirm-delete">Delete</button>
          {{Former::close()}}
        @endif
    @endif
</div>