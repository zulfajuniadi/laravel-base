<?php

class PermissionsController extends \BaseController {

	protected $validation_error_message = 'Validation Error.';
	protected $access_denied_message = 'Access denied.';
	protected $created_message = 'Record created.';
	protected $create_error_message = 'Error creating record.';
	protected $updated_message = 'Record updated.';
	protected $update_error_message = 'Error updating record.';
	protected $deleted_message = 'Record deleted.';
	protected $delete_error_message = 'Error deleting record.';

	/**
	 * Display a listing of permissions
	 *
	 * @return Response
	 */
	public function index()
	{
		
		if(!Permission::canList())
		{
			if(Request::ajax())
			{
				return Response::json($this->access_denied_message, 403);
			}
			return Redirect::back()
				->with('notification:danger', $this->access_denied_message);
		}

		$permissions = Permission::all();

		if(Request::ajax())
		{
			return $permissions;
		}

		return View::make('permissions.index', compact('permissions'));
	}

	/**
	 * Show the form for creating a new permission
	 *
	 * @return Response
	 */
	public function create()
	{
		if(Request::ajax())
		{
			return Response::json("Bad request", 400);
		}

		if(!Permission::canCreate())
		{
			return Redirect::back()
				->with('notification:danger', $this->access_denied_message);
		}
		return View::make('permissions.create');
	}

	/**
	 * Store a newly created permission in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Permission::$rules);
		
		if(!Permission::canCreate())
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

		$permission = Permission::create($data);
		if(!isset($permission->id))
		{
			if(Request::ajax())
			{
				return Response::json($this->create_error_message, 201);
			}
			return Redirect::back()
				->with('notification:danger', $this->create_error_message);
		}

		if(Request::ajax())
		{
			return Response::json($permission->toJson(), 201);
		}
		return Redirect::route('permissions.index')
			->with('notification:success', $this->created_message);
	}

	/**
	 * Display the specified permission.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$permission = Permission::findOrFail($id);
		
		if(!$permission->canShow())
		{
			if(Request::ajax())
			{
				return Response::json($this->access_denied_message, 403);
			}
			return Redirect::back()->with('notification:danger', $this->access_denied_message);
		}

		if(Request::ajax())
		{
			return Response::json($permission->toJson(), 201);
		}
		return View::make('permissions.show', compact('permission'));
	}

	/**
	 * Show the form for editing the specified permission.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$permission = Permission::find($id);

		if(Request::ajax())
		{
			return Response::json("Bad request", 400);
		}
		
		if(!$permission->canUpdate())
		{
			return Redirect::back()->with('notification:danger', $this->access_denied_message);
		}

		return View::make('permissions.edit', compact('permission'));
	}

	/**
	 * Update the specified permission in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$permission = Permission::findOrFail($id);
		
		if(!$permission->canUpdate())
		{
			if(Request::ajax())
			{
				return Response::json($this->access_denied_message, 403);
			}
			return Redirect::back()
				->with('notification:danger', $this->access_denied_message);
		}

		$validator = Validator::make($data = Input::all(), Permission::$rules);

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

		if(!$permission->update($data)){
			if(Request::ajax())
			{
				return Response::json($this->update_error_message, 500);
			}
			return Redirect::back()
				->withErrors($validator)
				->withInput()
				->with('notification:success', $this->update_error_message);
		}

		if(Request::ajax())
		{
			return $permission;
		}
		return Redirect::route('permissions.index')
			->with('notification:danger', $this->updated_message);
	}

	/**
	 * Remove the specified permission from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$permission = Permission::findOrFail($id);
		
		if(!$permission->canDelete())
		{
			if(Request::ajax())
			{
				return Response::json($this->access_denied_message, 403);
			}
			return Redirect::back()->with('notification:danger', $this->access_denied_message);
		}

		if(!$permission->delete()){
			if(Request::ajax())
			{
				return Response::json($this->delete_error_message, 500);
			}
			return Redirect::back()
				->withErrors($validator)
				->withInput()
				->with('notification:danger', $this->delete_error_message);

		}

		if(Request::ajax())
		{
			return Response::json($this->deleted_message);
		}

		return Redirect::route('permissions.index')
			->with('notification:success', $this->deleted_message);
	}

	public function __construct()
	{
		parent::__construct();
		View::share('controller', 'PermissionsController');
	}

}
