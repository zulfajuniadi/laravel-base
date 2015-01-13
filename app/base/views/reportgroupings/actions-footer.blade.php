<div class="well">
    @if(!isset($reportgrouping))
        <a href="{{action('ReportsController@show', $report_id)}}" class="btn btn-default">Back</a>  
    @endif
    @if(isset($has_submit))
        <button class="btn btn-primary">Submit</button>
    @endif
    @if(!isset($is_list) && ReportGrouping::canList())
        <a href="{{action('ReportGroupingsController@index', $report_id)}}" class="btn btn-default">List</a>  
    @endif
    @if(ReportGrouping::canCreate())
        <a href="{{action('ReportGroupingsController@create', $report_id)}}" class="btn btn-default">Create</a>
    @endif
    {{Former::close()}}
    @if(isset($reportgrouping))
        @if($reportgrouping->canShow())
          <a href="{{ action('ReportGroupingsController@show', [$report_id, $reportgrouping->id]) }}" class="btn btn-default">Details</a>
        @endif
        @if($reportgrouping->canUpdate())
          <a href="{{ action('ReportGroupingsController@edit', [$report_id, $reportgrouping->id]) }}" class="btn btn-default">Edit</a>
        @endif
        @if($reportgrouping->canDelete())
          {{Former::open(action('ReportGroupingsController@destroy', [$report_id, $reportgrouping->id]))->class('form-inline')}}
            {{Former::hidden('_method', 'DELETE')}}
            <button type="button" class="btn btn-default confirm-delete">Delete</button>
          {{Former::close()}}
        @endif
    @endif
</div>