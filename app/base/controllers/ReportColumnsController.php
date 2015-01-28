<?php

class ReportColumnsController extends \BaseController {

	/**
	 * Display a listing of reportcolumns
	 *
	 * @return Response
	 */
	public function index($report_id)
	{
		if(!ReportColumn::canList())
		{
			return $this->_access_denied();
		}
		if(Request::ajax())
		{
			$reportcolumns = ReportColumn::whereNotNull('report_columns.created_at');
			$reportcolumns->where('report_id', $report_id);
			$reportcolumns = $reportcolumns->select([
				'report_columns.id',
                'report_columns.order',
                'report_columns.name',
                'report_columns.label',
                'report_columns.options',
                'report_columns.mutator',
				'report_columns.id as actions'
             ]);
			return Datatables::of($reportcolumns)
                ->edit_column('actions', function($reportcolumn) use ($report_id) {
                    $actions   = [];
                    $actions[] = $reportcolumn->canShow() ? link_to_action('ReportColumnsController@show', 'Show', [$report_id, $reportcolumn->id], ['class' => 'btn btn-xs btn-primary'] ) : '';
                    $actions[] = $reportcolumn->canUpdate() ? link_to_action('ReportColumnsController@edit', 'Update', [$report_id, $reportcolumn->id], ['class' => 'btn btn-xs btn-default'] ) : '';
                    $actions[] = $reportcolumn->canDelete() ? Former::open(action('ReportColumnsController@destroy', [$report_id, $reportcolumn->id]))->class('form-inline') 
                    . Former::hidden('_method', 'DELETE')
                    . '<button type="button" class="btn btn-xs btn-danger confirm-delete">Delete</button>'
                    . Former::close() : '';
                    return implode(' ', $actions);
                })
                ->edit_column('options', function($reportfield) {
                	return nl2br($reportfield->options);
                })
                ->remove_column('id')
                ->make();
            return Datatables::of($reportcolumns)->make();
        }
        Asset::push('js', 'datatables');
        return View::make('reportcolumns.index', compact('report_id'));
    }

	/**
	 * Show the form for creating a new reportcolumn
	 *
	 * @return Response
	 */
	public function create($report_id)
	{
		if(Request::ajax())
		{
			return $this->_ajax_denied();
		}
		if(!ReportColumn::canCreate())
		{
			return $this->_access_denied();
		}
		$report = Report::findOrFail($report_id);
		return View::make('reportcolumns.create', compact('report_id', 'report'));
	}

	/**
	 * Store a newly created reportcolumn in storage.
	 *
	 * @return Response
	 */
	public function store($report_id)
	{
		$data = Input::all();
		ReportColumn::setRules('store');
		if(!ReportColumn::canCreate())
		{
			return $this->_access_denied();
		}
		$reportcolumn = new Reportcolumn;
		$data['report_id'] = $report_id;
		$reportcolumn->fill($data);
		if(!$reportcolumn->save())
		{
			return $this->_validation_error($reportcolumn);
		}
		if(Request::ajax())
		{
			return Response::json($reportcolumn, 201);
		}
		return Redirect::action('ReportColumnsController@index', $report_id)
         ->with('notification:success', $this->created_message);
     }

	/**
	 * Display the specified reportcolumn.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($report_id, $id)
	{
		$reportcolumn = ReportColumn::findOrFail($id);
		if(!$reportcolumn->canShow())
		{
			return $this->_access_denied();
		}
		if(Request::ajax())
		{
			return Response::json($reportcolumn);
		}
		$report = Report::findOrFail($report_id);
		Asset::push('js', 'show');
		return View::make('reportcolumns.show', compact('reportcolumn', 'report_id', 'report'));
	}

	/**
	 * Show the form for editing the specified reportcolumn.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($report_id, $id)
	{
		$reportcolumn = ReportColumn::findOrFail($id);
		if(Request::ajax())
		{
			return $this->_ajax_denied();
		}
		if(!$reportcolumn->canUpdate())
		{
			return _access_denied();
		}
		$report = Report::findOrFail($report_id);
		return View::make('reportcolumns.edit', compact('reportcolumn', 'report_id', 'report'));
	}

	/**
	 * Update the specified reportcolumn in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($report_id, $id)
	{
		$reportcolumn = ReportColumn::findOrFail($id);
		ReportColumn::setRules('update');
		$data = Input::all();
		if(!$reportcolumn->canUpdate())
		{
			return $this->_access_denied();
		}
		if(!$reportcolumn->update($data)) {
			return $this->_validation_error($reportcolumn);
		}
		if(Request::ajax())
		{
			return $reportcolumn;
		}
		Session::remove('_old_input');
		return Redirect::action('ReportColumnsController@edit', [$report_id, $id])
            ->with('notification:success', $this->updated_message);
    }

	/**
	 * Remove the specified reportcolumn from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($report_id, $id)
	{
		$reportcolumn = ReportColumn::findOrFail($id);
		if(!$reportcolumn->canDelete())
		{
			return $this->_access_denied();
		}
		$reportcolumn->delete();
		if(Request::ajax())
		{
			return Response::json($this->deleted_message);
		}
		return Redirect::action('ReportColumnsController@index', $report_id)
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
		View::share('controller', 'Reportcolumn');
	}

}
