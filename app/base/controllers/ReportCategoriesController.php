<?php

class ReportCategoriesController extends \BaseController {

	/**
	 * Display a listing of reports
	 *
	 * @return Response
	 */
	public function index()
	{
		if(!ReportCategory::canList())
		{
			return $this->_access_denied();
		}
		if(Request::ajax())
		{
			$reports = ReportCategory::select([
				'report_categories.id',
                'report_categories.name',
				'report_categories.id as actions'
             ]);
			return Datatables::of($reports)
                ->edit_column('actions', function($report){
                    $actions   = [];
                    $actions[] = $report->canShow() ? link_to_action('ReportCategoriesController@show', 'Show', $report->id, ['class' => 'btn btn-xs btn-primary'] ) : '';
                    $actions[] = $report->canUpdate() ? link_to_action('ReportCategoriesController@edit', 'Update', $report->id, ['class' => 'btn btn-xs btn-default'] ) : '';
                    $actions[] = $report->canDelete() ? Former::open(action('ReportCategoriesController@destroy', $report->id))->class('form-inline') 
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
        return View::make('reportcategories.index');
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
		if(!ReportCategory::canCreate())
		{
			return $this->_access_denied();
		}
        Breadcrumbs::push(action('ReportCategoriesController@create'), 'Create');
		return View::make('reportcategories.create');
	}

	/**
	 * Store a newly created report in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = Input::all();
		ReportCategory::setRules('store');
		if(!ReportCategory::canCreate())
		{
			return $this->_access_denied();
		}
		$report = new ReportCategory;
		$report->fill($data);
		if(!$report->save())
		{
			return $this->_validation_error($report);
		}
		if(Request::ajax())
		{
			return Response::json($report, 201);
		}
		return Redirect::action('ReportCategoriesController@index')
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
		$reportcategory = ReportCategory::findOrFail($id);
		if(!$reportcategory->canShow())
		{
			return $this->_access_denied();
		}
		if(Request::ajax())
		{
			return Response::json($reportcategory);
		}
		Asset::push('js', 'show');
        Breadcrumbs::push(action('ReportCategoriesController@edit', $id), 'View ' . $reportcategory->name);
		return View::make('reportcategories.show', compact('reportcategory'));
	}

	/**
	 * Show the form for editing the specified report.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$reportcategory = ReportCategory::findOrFail($id);
		if(Request::ajax())
		{
			return $this->_ajax_denied();
		}
		if(!$reportcategory->canUpdate())
		{
			return _access_denied();
		}
        Breadcrumbs::push(action('ReportCategoriesController@edit', $id), 'Edit ' . $reportcategory->name);
		return View::make('reportcategories.edit', compact('reportcategory'));
	}

	/**
	 * Update the specified report in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$reportcategory = ReportCategory::findOrFail($id);
		ReportCategory::setRules('update');
		$data = Input::all();
		if(!$reportcategory->canUpdate())
		{
			return $this->_access_denied();
		}
		if(!$reportcategory->update($data)) {
			return $this->_validation_error($reportcategory);
		}
		if(Request::ajax())
		{
			return $reportcategory;
		}
		Session::remove('_old_input');
		return Redirect::action('ReportCategoriesController@edit', $id)
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
		$reportcategory = ReportCategory::findOrFail($id);
		if(!$reportcategory->canDelete())
		{
			return $this->_access_denied();
		}
		$reportcategory->delete();
		if(Request::ajax())
		{
			return Response::json($this->deleted_message);
		}
		return Redirect::action('ReportCategoriesController@index')
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
        Breadcrumbs::push(action('ReportCategoriesController@index'), 'Report Categories');
		View::share('controller', 'Report');
	}

}
