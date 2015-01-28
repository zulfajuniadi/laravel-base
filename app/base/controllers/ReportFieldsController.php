<?php

class ReportFieldsController extends \BaseController {

	/**
	 * Display a listing of reportfields
	 *
	 * @return Response
	 */
	public function index($report_id)
	{
		if(!ReportField::canList())
		{
			return $this->_access_denied();
		}
		if(Request::ajax())
		{
			$reportfields = ReportField::whereNotNull('report_fields.created_at');	
			$reportfields->where('report_id', $report_id);
			$reportfields = $reportfields->select([
				'report_fields.id',
                'report_fields.order',
                'report_fields.name',
                'report_fields.label',
                'report_fields.type',
                'report_fields.options',
                'report_fields.default',
				'report_fields.id as actions'
            ]);
			$report = Report::findOrFail($report_id);
			return Datatables::of($reportfields)
                ->edit_column('actions', function($reportfield) use ($report_id) {
                    $actions   = [];
                    $actions[] = $reportfield->canShow() ? link_to_action('ReportFieldsController@show', 'Show', [$report_id, $reportfield->id], ['class' => 'btn btn-xs btn-primary'] ) : '';
                    $actions[] = $reportfield->canUpdate() ? link_to_action('ReportFieldsController@edit', 'Update', [$report_id, $reportfield->id], ['class' => 'btn btn-xs btn-default'] ) : '';
                    $actions[] = $reportfield->canDelete() ? Former::open(action('ReportFieldsController@destroy', [$report_id, $reportfield->id]))->class('form-inline') 
                    . Former::hidden('_method', 'DELETE')
                    . '<button type="button" class="btn btn-xs btn-danger confirm-delete">Delete</button>'
                    . Former::close() : '';
                    return implode(' ', $actions);
                })
                ->edit_column('type', function($reportfield) use ($report) {
                	return $report->fieldTypes[$reportfield->type];
                })
                ->edit_column('options', function($reportfield) {
                	return nl2br($reportfield->options);
                })
                ->remove_column('id')
                ->make();
            return Datatables::of($reportfields)->make();
        }
        Asset::push('js', 'datatables');
        return View::make('reportfields.index', compact('report_id'));
    }

	/**
	 * Show the form for creating a new reportfield
	 *
	 * @return Response
	 */
	public function create($report_id)
	{
		if(Request::ajax())
		{
			return $this->_ajax_denied();
		}
		if(!ReportField::canCreate())
		{
			return $this->_access_denied();
		}
		$report = Report::findOrFail($report_id);
		return View::make('reportfields.create', compact('report_id', 'report'));
	}

	/**
	 * Store a newly created reportfield in storage.
	 *
	 * @return Response
	 */
	public function store($report_id)
	{
		$data = Input::all();
		ReportField::setRules('store');
		if(!ReportField::canCreate())
		{
			return $this->_access_denied();
		}
		$reportfield = new Reportfield;
		$data['report_id'] = $report_id;
		$reportfield->fill($data);
		if(!$reportfield->save())
		{
			return $this->_validation_error($reportfield);
		}
		if(Request::ajax())
		{
			return Response::json($reportfield, 201);
		}
		return Redirect::action('ReportFieldsController@index', $report_id)
         ->with('notification:success', $this->created_message);
     }

	/**
	 * Display the specified reportfield.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($report_id, $id)
	{
		$reportfield = ReportField::findOrFail($id);
		$report = Report::findOrFail($report_id);
		if(!$reportfield->canShow())
		{
			return $this->_access_denied();
		}
		if(Request::ajax())
		{
			return Response::json($reportfield);
		}
		Asset::push('js', 'show');
		return View::make('reportfields.show', compact('report_id', 'report', 'reportfield'));
	}

	/**
	 * Show the form for editing the specified reportfield.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($report_id, $id)
	{
		$reportfield = ReportField::findOrFail($id);
		if(Request::ajax())
		{
			return $this->_ajax_denied();
		}
		if(!$reportfield->canUpdate())
		{
			return _access_denied();
		}
		$report = Report::findOrFail($report_id);
		return View::make('reportfields.edit', compact('report_id', 'report', 'reportfield'));
	}

	/**
	 * Update the specified reportfield in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($report_id, $id)
	{
		$reportfield = ReportField::findOrFail($id);
		ReportField::setRules('update');
		$data = Input::all();
		if(!$reportfield->canUpdate())
		{
			return $this->_access_denied();
		}
		if(!$reportfield->update($data)) {
			return $this->_validation_error($reportfield);
		}
		if(Request::ajax())
		{
			return $reportfield;
		}
		Session::remove('_old_input');
		return Redirect::action('ReportFieldsController@edit', [$report_id, $id])
            ->with('notification:success', $this->updated_message);
    }

	/**
	 * Remove the specified reportfield from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$reportfield = ReportField::findOrFail($id);
		if(!$reportfield->canDelete())
		{
			return $this->_access_denied();
		}
		$reportfield->delete();
		if(Request::ajax())
		{
			return Response::json($this->deleted_message);
		}
		return Redirect::action('ReportFieldsController@index')
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
		View::share('controller', 'Reportfield');
	}

}
