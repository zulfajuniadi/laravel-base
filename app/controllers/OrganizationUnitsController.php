<?php

class OrganizationUnitsController extends \BaseController {

	protected $validation_error_message = 'Validation Error.';
	protected $access_denied_message = 'Access denied.';
	protected $created_message = 'Record created.';
	protected $create_error_message = 'Error creating record.';
	protected $updated_message = 'Record updated.';
	protected $update_error_message = 'Error updating record.';
	protected $deleted_message = 'Record deleted.';
	protected $delete_error_message = 'Error deleting record.';

	/**
	 * Display a listing of organizationunits
	 *
	 * @return Response
	 */
	public function index()
	{
		
		if(!OrganizationUnit::canList())
		{
			if(Request::ajax())
			{
				return Response::json($this->access_denied_message, 403);
			}
			return Redirect::back()
				->with('notification:danger', $this->access_denied_message);
		}
		
		if(Request::ajax())
		{
			$organization_units = OrganizationUnit::select(['organization_units.id', 'organization_units.name',  DB::raw('parent.name as pname'), 'users.username'])
				-> leftJoin('users', 'organization_units.user_id', '=', 'users.id')
				-> leftJoin(DB::raw('organization_units as "parent"'), 'organization_units.parent_id', '=', 'parent.id')
				-> groupBy('organization_units.id');
			return Datatables::of($organization_units)
        ->add_column('actions', '{{View::make("organizationunits.actions-row", compact("id"))->render()}}')
				->remove_column('id')
				->make();
		}

		$script_name = 'index';
		$style_name = 'index';
		return View::make('organizationunits.index', compact('script_name', 'style_name'));
	}

	/**
	 * Show the form for creating a new organizationunit
	 *
	 * @return Response
	 */
	public function create()
	{
		if(Request::ajax())
		{
			return Response::json("Bad request", 400);
		}

		if(!OrganizationUnit::canCreate())
		{
			return Redirect::back()
				->with('notification:danger', $this->access_denied_message);
		}
		return View::make('organizationunits.create');
	}

	/**
	 * Store a newly created organizationunit in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), OrganizationUnit::$rules['store']);
		
		if(!OrganizationUnit::canCreate())
		{
			if(Request::ajax())
			{
				return Response::json($this->access_denied_message, 403);
			}
			return Redirect::back()
				->with('notification:danger', $this->access_denied_message);
		}

		if ($validator->fails())
		{
			if(Request::ajax())
			{
				return Response::json($validator->messages(), 400);
			}
			return Redirect::back()
				->withErrors($validator)
				->withInput()
				->with('notification:danger', $this->validation_error_message);
		}

		Event::fire('OrganizationUnit.before.create', [$data]);

		$organizationunit = OrganizationUnit::create($data);
		$organizationunit->makeChildOf($data['parent_id']);

		if(!isset($organizationunit->id))
		{
			if(Request::ajax())
			{
				return Response::json($this->create_error_message, 201);
			}
			return Redirect::back()
				->with('notification:danger', $this->create_error_message);
		}

		Event::fire('OrganizationUnit.after.create', [$organizationunit]);

		if(Request::ajax())
		{
			return Response::json($organizationunit->toJson(), 201);
		}
		return Redirect::route('organizationunits.index')
			->with('notification:success', $this->created_message);
	}

	/**
	 * Display the specified organizationunit.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$organizationunit = OrganizationUnit::findOrFail($id);
		
		if(!$organizationunit->canShow())
		{
			if(Request::ajax())
			{
				return Response::json($this->access_denied_message, 403);
			}
			return Redirect::back()->with('notification:danger', $this->access_denied_message);
		}

		if(Request::ajax())
		{
			return Response::json($organizationunit->toJson(), 201);
		}
		$script_name = 'show';
		return View::make('organizationunits.show', compact('organizationunit', 'script_name'));
	}

	/**
	 * Show the form for editing the specified organizationunit.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$organizationunit = OrganizationUnit::find($id);

		if(Request::ajax())
		{
			return Response::json("Bad request", 400);
		}
		
		if(!$organizationunit->canUpdate())
		{
			return Redirect::back()->with('notification:danger', $this->access_denied_message);
		}

		return View::make('organizationunits.edit', compact('organizationunit'));
	}

	/**
	 * Update the specified organizationunit in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$organizationunit = OrganizationUnit::findOrFail($id);
		
		if(!$organizationunit->canUpdate())
		{
			if(Request::ajax())
			{
				return Response::json($this->access_denied_message, 403);
			}
			return Redirect::back()
				->with('notification:danger', $this->access_denied_message);
		}

		$validator = Validator::make($data = Input::all(), OrganizationUnit::$rules['update']);

		if ($validator->fails())
		{
			if(Request::ajax())
			{
				return Response::json($validator->messages(), 400);
			}
			return Redirect::back()
				->withErrors($validator)
				->withInput()
				->with('notification:danger', $this->validation_error_message);
		}

		Event::fire('OrganizationUnit.before.update', [$organizationunit]);

		if(!$organizationunit->update($data)){
			if(Request::ajax())
			{
				return Response::json($this->update_error_message, 500);
			}
			return Redirect::back()
				->withErrors($validator)
				->withInput()
				->with('notification:danger', $this->update_error_message);
		}

		$organizationunit->makeChildOf($data['parent_id']);

		Event::fire('OrganizationUnit.after.update', [$organizationunit]);

		if(Request::ajax())
		{
			return $organizationunit;
		}
		return Redirect::back()
			->with('notification:success', $this->updated_message);
	}

	/**
	 * Remove the specified organizationunit from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$organizationunit = OrganizationUnit::findOrFail($id);
		
		if(!$organizationunit->canDelete())
		{
			if(Request::ajax())
			{
				return Response::json($this->access_denied_message, 403);
			}
			return Redirect::back()->with('notification:danger', $this->access_denied_message);
		}

		Event::fire('OrganizationUnit.before.delete', [$organizationunit]);

		if(!$organizationunit->delete()){
			if(Request::ajax())
			{
				return Response::json($this->delete_error_message, 500);
			}
			return Redirect::back()
				->withErrors($validator)
				->withInput()
				->with('notification:danger', $this->delete_error_message);
		}

		Event::fire('OrganizationUnit.after.update', [$organizationunit]);

		if(Request::ajax())
		{
			return Response::json($this->deleted_message);
		}

		return Redirect::route('organizationunits.index')
			->with('notification:success', $this->deleted_message);
	}

	public function __construct()
	{
		parent::__construct();
		View::share('controller', 'OrganizationUnitsController');
	}

}
