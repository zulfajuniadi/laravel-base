<div class="well">
    @if(isset($has_submit))
        <button class="btn btn-primary">Submit</button>
    @endif
    @if(!isset($is_list) && Report::canList())
        <a href="{{action('ReportsController@index')}}" class="btn btn-default">List</a>  
    @endif
    @if(Report::canCreate())
        <a href="{{action('ReportsController@create')}}" class="btn btn-default">Create</a>
    @endif
    {{Former::close()}}
    @if(isset($report))
        <a href="{{ action('ReportEagersController@show', $report->id) }}" class="btn btn-default">Show Eager Loads</a>
        <a href="{{ action('ReportFieldsController@show', $report->id) }}" class="btn btn-default">Show Filters</a>
        <a href="{{ action('ReportColumnsController@show', $report->id) }}" class="btn btn-default">Show Columns</a>
        <a href="{{ action('ReportGroupingsController@show', $report->id) }}" class="btn btn-default">Show Groupings</a>
        @if($report->canShow())
          <a href="{{ action('ReportsController@show', $report->id) }}" class="btn btn-default">Details</a>
        @endif
        @if($report->canUpdate())
          <a href="{{ action('ReportsController@edit', $report->id) }}" class="btn btn-default">Edit</a>
        @endif
        @if($report->canDelete())
          {{Former::open(action('ReportsController@destroy', $report->id))->class('form-inline')}}
            {{Former::hidden('_method', 'DELETE')}}
            <button type="button" class="btn btn-default confirm-delete">Delete</button>
          {{Former::close()}}
        @endif
    @endif
</div>