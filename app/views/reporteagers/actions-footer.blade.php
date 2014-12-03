<div class="well">
    @if(!isset($reporteager))
        <a href="{{action('ReportsController@show', $report_id)}}" class="btn btn-default">Back</a>  
    @endif
    @if(isset($has_submit))
        <button class="btn btn-primary">Submit</button>
    @endif
    @if(!isset($is_list) && ReportEager::canList())
        <a href="{{action('ReportEagersController@index', $report_id)}}" class="btn btn-default">List</a>  
    @endif
    @if(ReportEager::canCreate())
        <a href="{{action('ReportEagersController@create', $report_id)}}" class="btn btn-default">Create</a>
    @endif
    {{Former::close()}}
    @if(isset($reporteager))
        @if($reporteager->canShow())
          <a href="{{ action('ReportEagersController@show', $report_id, $reporteager->id) }}" class="btn btn-default">Details</a>
        @endif
        @if($reporteager->canUpdate())
          <a href="{{ action('ReportEagersController@edit', $report_id, $reporteager->id) }}" class="btn btn-default">Edit</a>
        @endif
        @if($reporteager->canDelete())
          {{Former::open(action('ReportEagersController@destroy', $report_id, $reporteager->id))->class('form-inline')}}
            {{Former::hidden('_method', 'DELETE')}}
            <button type="button" class="btn btn-default confirm-delete">Delete</button>
          {{Former::close()}}
        @endif
    @endif
</div>