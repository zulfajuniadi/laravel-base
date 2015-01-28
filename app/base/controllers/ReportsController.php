<?php

class ReportsController extends \BaseController {

	/**
	 * Display a listing of reports
	 *
	 * @return Response
	 */
	public function index()
	{
		if(!Report::canList())
		{
			return $this->_access_denied();
		}
		if(Request::ajax())
		{
			$reports = Report::whereNotNull('reports.created_at');	
			$reports = $reports->select([
				'reports.id',
                'reports.report_category_id',
                'reports.name',
                'reports.model',
                'reports.path',
                'reports.is_json',
				'reports.id as actions'
             ]);
			return Datatables::of($reports)
                ->edit_column('report_category_id', function($report){
                	return $report->category->name;
                })
                ->edit_column('actions', function($report){
                    $actions   = [];
                    $actions[] = $report->canShow() ? link_to_action('ReportsController@show', 'Show', $report->id, ['class' => 'btn btn-xs btn-primary'] ) : '';
                    $actions[] = $report->canUpdate() ? link_to_action('ReportsController@edit', 'Update', $report->id, ['class' => 'btn btn-xs btn-default'] ) : '';
                    $actions[] = $report->canDelete() ? Former::open(action('ReportsController@destroy', $report->id))->class('form-inline') 
                    . Former::hidden('_method', 'DELETE')
                    . '<button type="button" class="btn btn-xs btn-danger confirm-delete">Delete</button>'
                    . Former::close() : '';
                    return implode(' ', $actions);
                })
                ->remove_column('id')
                ->make();
            return Datatables::of($reports)->make();
        }
        Asset::push('js', 'datatables');
        return View::make('reports.index');
    }

	/**
	 * Show the form for creating a new report
	 *
	 * @return Response
	 */
	public function create()
	{
		if(Request::ajax())
		{
			return $this->_ajax_denied();
		}
		if(!Report::canCreate())
		{
			return $this->_access_denied();
		}
		return View::make('reports.create');
	}

	/**
	 * Store a newly created report in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = Input::all();
		Report::setRules('store');
		if(!Report::canCreate())
		{
			return $this->_access_denied();
		}
		$report = new Report;
		$report->fill($data);
		if(!$report->save())
		{
			return $this->_validation_error($report);
		}
		if(Request::ajax())
		{
			return Response::json($report, 201);
		}
		return Redirect::action('ReportsController@index')
         ->with('notification:success', $this->created_message);
     }

	/**
	 * Display the specified report.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$report = Report::findOrFail($id);
		if(!$report->canShow())
		{
			return $this->_access_denied();
		}
		if(Request::ajax())
		{
			return Response::json($report);
		}
		Asset::push('js', 'show');
		return View::make('reports.show', compact('report'));
	}

	/**
	 * Show the form for editing the specified report.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$report = Report::findOrFail($id);
		if(Request::ajax())
		{
			return $this->_ajax_denied();
		}
		if(!$report->canUpdate())
		{
			return _access_denied();
		}
		return View::make('reports.edit', compact('report'));
	}

	/**
	 * Update the specified report in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$report = Report::findOrFail($id);
		Report::setRules('update');
		$data = Input::all();
		if(!$report->canUpdate())
		{
			return $this->_access_denied();
		}
		if(!$report->update($data)) {
			return $this->_validation_error($report);
		}
		if(Request::ajax())
		{
			return $report;
		}
		Session::remove('_old_input');
		return Redirect::action('ReportsController@edit', $id)
            ->with('notification:success', $this->updated_message);
    }

	/**
	 * Remove the specified report from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$report = Report::findOrFail($id);
		if(!$report->canDelete())
		{
			return $this->_access_denied();
		}
		$report->delete();
		if(Request::ajax())
		{
			return Response::json($this->deleted_message);
		}
		return Redirect::action('ReportsController@index')
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
		View::share('controller', 'Report');
	}

}
