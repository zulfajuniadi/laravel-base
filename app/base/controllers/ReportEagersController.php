<?php

class ReportEagersController extends \BaseController {

	/**
	 * Display a listing of reporteagers
	 *
	 * @return Response
	 */
	public function index($report_id)
	{
		if(!ReportEager::canList())
		{
			return $this->_access_denied();
		}
		if(Request::ajax())
		{
			$reporteagers = ReportEager::whereNotNull('report_eagers.created_at');	
			$reporteagers->where('report_id', $report_id);
			$reporteagers = $reporteagers->select([
				'report_eagers.id',
                'report_eagers.name',
				'report_eagers.id as actions'
             ]);
			return Datatables::of($reporteagers)
                ->edit_column('actions', function($reporteager) use ($report_id) {
                    $actions   = [];
                    $actions[] = $reporteager->canShow() ? link_to_action('ReportEagersController@show', 'Show', [$report_id, $reporteager->id], ['class' => 'btn btn-xs btn-primary'] ) : '';
                    $actions[] = $reporteager->canUpdate() ? link_to_action('ReportEagersController@edit', 'Update', [$report_id, $reporteager->id], ['class' => 'btn btn-xs btn-default'] ) : '';
                    $actions[] = $reporteager->canDelete() ? Former::open(action('ReportEagersController@destroy', [$report_id, $reporteager->id]))->class('form-inline') 
                    . Former::hidden('_method', 'DELETE')
                    . '<button type="button" class="btn btn-xs btn-danger confirm-delete">Delete</button>'
                    . Former::close() : '';
                    return implode(' ', $actions);
                })
                ->remove_column('id')
                ->make();
            return Datatables::of($reporteagers)->make();
        }
        Asset::push('js', 'datatables');
        return View::make('reporteagers.index', compact('report_id'));
    }

	/**
	 * Show the form for creating a new reporteager
	 *
	 * @return Response
	 */
	public function create($report_id)
	{
		if(Request::ajax())
		{
			return $this->_ajax_denied();
		}
		if(!ReportEager::canCreate())
		{
			return $this->_access_denied();
		}
		$report = Report::findOrFail($report_id);
		return View::make('reporteagers.create', compact('report_id', 'report'));
	}

	/**
	 * Store a newly created reporteager in storage.
	 *
	 * @return Response
	 */
	public function store($report_id)
	{
		$data = Input::all();
		ReportEager::setRules('store');
		if(!ReportEager::canCreate())
		{
			return $this->_access_denied();
		}
		$reporteager = new Reporteager;
		$data['report_id'] = $report_id;
		$reporteager->fill($data);
		if(!$reporteager->save())
		{
			return $this->_validation_error($reporteager);
		}
		if(Request::ajax())
		{
			return Response::json($reporteager, 201);
		}
		return Redirect::action('ReportEagersController@index', $report_id)
         ->with('notification:success', $this->created_message);
     }

	/**
	 * Display the specified reporteager.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($report_id, $id)
	{
		$reporteager = ReportEager::findOrFail($id);
		if(!$reporteager->canShow())
		{
			return $this->_access_denied();
		}
		if(Request::ajax())
		{
			return Response::json($reporteager);
		}
		$report = Report::findOrFail($report_id);
		Asset::push('js', 'show');
		return View::make('reporteagers.show', compact('report_id', 'reporteager', 'report'));
	}

	/**
	 * Show the form for editing the specified reporteager.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($report_id, $id)
	{
		$reporteager = ReportEager::findOrFail($id);
		if(Request::ajax())
		{
			return $this->_ajax_denied();
		}
		if(!$reporteager->canUpdate())
		{
			return _access_denied();
		}
		$report = Report::findOrFail($report_id);
		return View::make('reporteagers.edit', compact('reporteager', 'report_id', 'report'));
	}

	/**
	 * Update the specified reporteager in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($report_id, $id)
	{
		$reporteager = ReportEager::findOrFail($id);
		ReportEager::setRules('update');
		$data = Input::all();
		if(!$reporteager->canUpdate())
		{
			return $this->_access_denied();
		}
		if(!$reporteager->update($data)) {
			return $this->_validation_error($reporteager);
		}
		if(Request::ajax())
		{
			return $reporteager;
		}
		Session::remove('_old_input');
		return Redirect::action('ReportEagersController@edit', [$report_id, $id])
            ->with('notification:success', $this->updated_message);
    }

	/**
	 * Remove the specified reporteager from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($report_id, $id)
	{
		$reporteager = ReportEager::findOrFail($id);
		if(!$reporteager->canDelete())
		{
			return $this->_access_denied();
		}
		$reporteager->delete();
		if(Request::ajax())
		{
			return Response::json($this->deleted_message);
		}
		return Redirect::action('ReportEagersController@index', $report_id)
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
		View::share('controller', 'Reporteager');
	}

}
