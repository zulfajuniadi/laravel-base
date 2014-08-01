<?php

class RolesController extends \BaseController {

	protected $validation_error_message = 'Validation Error.';
	protected $access_denied_message = 'Access denied.';
	protected $created_message = 'Record created.';
	protected $create_error_message = 'Error creating record.';
	protected $updated_message = 'Record updated.';
	protected $update_error_message = 'Error updating record.';
	protected $deleted_message = 'Record deleted.';
	protected $delete_error_message = 'Error deleting record.';

	/**
	 * Display a listing of roles
	 *
	 * @return Response
	 */
	public function index()
	{
		
		if(!Role::canList())
		{
			if(Request::ajax())
			{
				return Response::json($this->access_denied_message, 403);
			}
			return Redirect::back()
				->with('notification', $this->access_denied_message);
		}

		$roles = Role::all();

		if(Request::ajax())
		{
			return $roles;
		}

		return View::make('roles.index', compact('roles'));
	}

	/**
	 * Show the form for creating a new role
	 *
	 * @return Response
	 */
	public function create()
	{
		if(Request::ajax())
		{
			return Response::json("Bad request", 400);
		}

		if(!Role::canCreate())
		{
			return Redirect::back()
				->with('notification', $this->access_denied_message);
		}
		return View::make('roles.create');
	}

	/**
	 * Store a newly created role in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Role::$rules);
		
		if(!Role::canCreate())
		{
			if(Request::ajax())
			{
				return Response::json($this->access_denied_message, 403);
			}
			return Redirect::back()
				->with('notification', $this->access_denied_message);
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
				->with('notification', $this->validation_error_message);
		}

		$role = Role::create($data);
		if(!isset($role->id))
		{
			if(Request::ajax())
			{
				return Response::json($this->create_error_message, 201);
			}
			return Redirect::back()
				->with('notification', $this->create_error_message);
		}

		if(Request::ajax())
		{
			return Response::json($role->toJson(), 201);
		}
		return Redirect::route('roles.index')
			->with('notification', $this->created_message);
	}

	/**
	 * Display the specified role.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$role = Role::findOrFail($id);
		
		if(!$role->canShow())
		{
			if(Request::ajax())
			{
				return Response::json($this->access_denied_message, 403);
			}
			return Redirect::back()->with('notification', $this->access_denied_message);
		}

		if(Request::ajax())
		{
			return Response::json($role->toJson(), 201);
		}
		return View::make('roles.show', compact('role'));
	}

	/**
	 * Show the form for editing the specified role.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$role = Role::find($id);

		if(Request::ajax())
		{
			return Response::json("Bad request", 400);
		}
		
		if(!$role->canUpdate())
		{
			return Redirect::back()->with('notification', $this->access_denied_message);
		}

		return View::make('roles.edit', compact('role'));
	}

	/**
	 * Update the specified role in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$role = Role::findOrFail($id);
		
		if(!$role->canUpdate())
		{
			if(Request::ajax())
			{
				return Response::json($this->access_denied_message, 403);
			}
			return Redirect::back()
				->with('notification', $this->access_denied_message);
		}

		$validator = Validator::make($data = Input::all(), Role::$rules);

		if ($validator->fails())
		{
			if(Request::ajax())
			{
				return Response::json($validator->messages(), 400);
			}
			return Redirect::back()
				->withErrors($validator)
				->withInput()
				->with('notification', $this->validation_error_message);
		}

		if(!$role->update($data)){
			if(Request::ajax())
			{
				return Response::json($this->update_error_message, 500);
			}
			return Redirect::back()
				->withErrors($validator)
				->withInput()
				->with('notification', $this->update_error_message);
		}

		if(Request::ajax())
		{
			return $role;
		}
		return Redirect::route('roles.index')
			->with('notification', $this->updated_message);
	}

	/**
	 * Remove the specified role from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$role = Role::findOrFail($id);
		
		if(!$role->canDelete())
		{
			if(Request::ajax())
			{
				return Response::json($this->access_denied_message, 403);
			}
			return Redirect::back()->with('notification', $this->access_denied_message);
		}

		if(!$role->delete()){
			if(Request::ajax())
			{
				return Response::json($this->delete_error_message, 500);
			}
			return Redirect::back()
				->withErrors($validator)
				->withInput()
				->with('notification', $this->delete_error_message);

		}

		if(Request::ajax())
		{
			return Response::json($this->deleted_message, 403);
		}

		return Redirect::route('roles.index')
			->with('notification', $this->deleted_message);
	}

}
