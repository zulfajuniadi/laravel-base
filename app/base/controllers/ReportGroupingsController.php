<?php

class ReportGroupingsController extends \BaseController {

	/**
	 * Display a listing of reportgroupings
	 *
	 * @return Response
	 */
	public function index($report_id)
	{
		if(!ReportGrouping::canList())
		{
			return $this->_access_denied();
		}
		if(Request::ajax())
		{
			$reportgroupings = ReportGrouping::whereNotNull('report_groupings.created_at');	
			$reportgroupings->where('report_id', $report_id);
			$reportgroupings = $reportgroupings->select([
				'report_groupings.id',
                'report_groupings.name',
                'report_groupings.label',
				'report_groupings.id as actions'
             ]);
			return Datatables::of($reportgroupings)
                ->edit_column('actions', function($reportgrouping) use ($report_id) {
                    $actions   = [];
                    $actions[] = $reportgrouping->canShow() ? link_to_action('ReportGroupingsController@show', 'Show', [$report_id, $reportgrouping->id], ['class' => 'btn btn-xs btn-primary'] ) : '';
                    $actions[] = $reportgrouping->canUpdate() ? link_to_action('ReportGroupingsController@edit', 'Update', [$report_id, $reportgrouping->id], ['class' => 'btn btn-xs btn-default'] ) : '';
                    $actions[] = $reportgrouping->canDelete() ? Former::open(action('ReportGroupingsController@destroy', [$report_id, $reportgrouping->id]))->class('form-inline') 
                    . Former::hidden('_method', 'DELETE')
                    . '<button type="button" class="btn btn-xs btn-danger confirm-delete">Delete</button>'
                    . Former::close() : '';
                    return implode(' ', $actions);
                })
                ->remove_column('id')
                ->make();
            return Datatables::of($reportgroupings)->make();
        }
        Asset::push('js', 'datatables');
        return View::make('reportgroupings.index', compact('report_id'));
    }

	/**
	 * Show the form for creating a new reportgrouping
	 *
	 * @return Response
	 */
	public function create($report_id)
	{
		if(Request::ajax())
		{
			return $this->_ajax_denied();
		}
		if(!ReportGrouping::canCreate())
		{
			return $this->_access_denied();
		}
		$report = Report::findOrFail($report_id);
		return View::make('reportgroupings.create', compact('report_id', 'report'));
	}

	/**
	 * Store a newly created reportgrouping in storage.
	 *
	 * @return Response
	 */
	public function store($report_id)
	{
		$data = Input::all();
		ReportGrouping::setRules('store');
		if(!ReportGrouping::canCreate())
		{
			return $this->_access_denied();
		}
		$reportgrouping = new Reportgrouping;
		$data['report_id'] = $report_id;
		$reportgrouping->fill($data);
		if(!$reportgrouping->save())
		{
			return $this->_validation_error($reportgrouping);
		}
		if(Request::ajax())
		{
			return Response::json($reportgrouping, 201);
		}
		return Redirect::action('ReportGroupingsController@index', $report_id)
         ->with('notification:success', $this->created_message);
     }

	/**
	 * Display the specified reportgrouping.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($report_id, $id)
	{
		$reportgrouping = ReportGrouping::findOrFail($id);
		if(!$reportgrouping->canShow())
		{
			return $this->_access_denied();
		}
		if(Request::ajax())
		{
			return Response::json($reportgrouping);
		}
		$report = Report::findOrFail($report_id);
		Asset::push('js', 'show');
		return View::make('reportgroupings.show', compact('reportgrouping', 'report_id', 'report'));
	}

	/**
	 * Show the form for editing the specified reportgrouping.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($report_id, $id)
	{
		$reportgrouping = ReportGrouping::findOrFail($id);
		if(Request::ajax())
		{
			return $this->_ajax_denied();
		}
		if(!$reportgrouping->canUpdate())
		{
			return _access_denied();
		}
		$report = Report::findOrFail($report_id);
		return View::make('reportgroupings.edit', compact('reportgrouping', 'report_id', 'report'));
	}

	/**
	 * Update the specified reportgrouping in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($report_id, $id)
	{
		$reportgrouping = ReportGrouping::findOrFail($id);
		ReportGrouping::setRules('update');
		$data = Input::all();
		if(!$reportgrouping->canUpdate())
		{
			return $this->_access_denied();
		}
		if(!$reportgrouping->update($data)) {
			return $this->_validation_error($reportgrouping);
		}
		if(Request::ajax())
		{
			return $reportgrouping;
		}
		Session::remove('_old_input');
		return Redirect::action('ReportGroupingsController@edit', [$report_id, $id])
            ->with('notification:success', $this->updated_message);
    }

	/**
	 * Remove the specified reportgrouping from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($report_id, $id)
	{
		$reportgrouping = ReportGrouping::findOrFail($id);
		if(!$reportgrouping->canDelete())
		{
			return $this->_access_denied();
		}
		$reportgrouping->delete();
		if(Request::ajax())
		{
			return Response::json($this->deleted_message);
		}
		return Redirect::action('ReportGroupingsController@index', $report_id)
            ->with('notification:success', $this->deleted_message);
    }

	/**
	 * Custom Methods. Dont forget to add these to routes: Route::get('example/name', 'ExampleController@getName');
	 */
	
	// public function getName()
	// {
	// }

	/**
	 * Constructor
	 */

	public function __construct()
	{
		parent::__construct();
		View::share('controller', 'Reportgrouping');
	}

}
