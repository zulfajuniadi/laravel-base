<div class="well">
    @if(!isset($reportfield))
        <a href="{{action('ReportsController@show', $report_id)}}" class="btn btn-default">Back</a>  
    @endif
    @if(isset($has_submit))
        <button class="btn btn-primary">Submit</button>
    @endif
    @if(!isset($is_list) && ReportField::canList())
        <a href="{{action('ReportFieldsController@index', $report_id)}}" class="btn btn-default">List</a>  
    @endif
    @if(ReportField::canCreate())
        <a href="{{action('ReportFieldsController@create', $report_id)}}" class="btn btn-default">Create</a>
    @endif
    {{Former::close()}}
    @if(isset($reportfield))
        @if($reportfield->canShow())
          <a href="{{ action('ReportFieldsController@show', [$report_id, $reportfield->id]) }}" class="btn btn-default">Details</a>
        @endif
        @if($reportfield->canUpdate())
          <a href="{{ action('ReportFieldsController@edit', [$report_id, $reportfield->id]) }}" class="btn btn-default">Edit</a>
        @endif
        @if($reportfield->canDelete())
          {{Former::open(action('ReportFieldsController@destroy', [$report_id, $reportfield->id]))->class('form-inline')}}
            {{Former::hidden('_method', 'DELETE')}}
            <button type="button" class="btn btn-default confirm-delete">Delete</button>
          {{Former::close()}}
        @endif
    @endif
</div>