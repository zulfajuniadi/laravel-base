<div class="well">
    @if(!isset($reportcolumn))
        <a href="{{action('ReportsController@show', $report_id)}}" class="btn btn-default">Back</a>  
    @endif
    @if(isset($has_submit))
        <button class="btn btn-primary">Submit</button>
    @endif
    @if(!isset($is_list) && ReportColumn::canList())
        <a href="{{action('ReportColumnsController@index', $report_id)}}" class="btn btn-default">List</a>  
    @endif
    @if(ReportColumn::canCreate())
        <a href="{{action('ReportColumnsController@create', $report_id)}}" class="btn btn-default">Create</a>
    @endif
    {{Former::close()}}
    @if(isset($reportcolumn))
        @if($reportcolumn->canShow())
          <a href="{{ action('ReportColumnsController@show', [$report_id, $reportcolumn->id]) }}" class="btn btn-default">Details</a>
        @endif
        @if($reportcolumn->canUpdate())
          <a href="{{ action('ReportColumnsController@edit', [$report_id, $reportcolumn->id]) }}" class="btn btn-default">Edit</a>
        @endif
        @if($reportcolumn->canDelete())
          {{Former::open(action('ReportColumnsController@destroy', [$report_id, $reportcolumn->id]))->class('form-inline')}}
            {{Former::hidden('_method', 'DELETE')}}
            <button type="button" class="btn btn-default confirm-delete">Delete</button>
          {{Former::close()}}
        @endif
    @endif
</div>