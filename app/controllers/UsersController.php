<?php

class UsersController extends \BaseController {

	protected $validation_error_message = 'Validation Error.';
	protected $access_denied_message = 'Access denied.';
	protected $created_message = 'Record created.';
	protected $create_error_message = 'Error creating record.';
	protected $updated_message = 'Record updated.';
	protected $update_error_message = 'Error updating record.';
	protected $deleted_message = 'Record deleted.';
	protected $delete_error_message = 'Error deleting record.';
	protected $set_password_error_message = 'Error setting password.';
	protected $set_password_message = 'Password set succesfully.';
	protected $set_confirmation_error_message = 'Error setting activation.';
	protected $set_confirmation_message = 'Activation set succesfully.';
	protected $change_password_invalid_message = 'Invalid Old Password.';
	protected $change_password_error_message = 'Error changing password.';
	protected $change_password_message = 'Password changed succesfully.';

	/**
	 * Display a listing of users
	 *
	 * @return Response
	 */
	public function index()
	{
		
		if(!User::canList())
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
			$users_under_me = Auth::user()->get_authorized_userids(User::$show_authorize_flag);
			if(empty($users_under_me)) {
				$users = User::whereNotNull('users.created_at');	
			} else {
				$users = User::whereIn('users.user_id', $users_under_me);	
			}
			$users = $users->select(['users.id', 'users.username', 'organization_units.name', DB::raw('count(assigned_roles.id)'), 'users.confirmed'])
				-> leftJoin('assigned_roles', 'assigned_roles.user_id', '=', 'users.id')
				-> leftJoin('organization_units', 'organization_units.id', '=', 'users.organizationunit_id')
				-> groupBy('users.id');
			return Datatables::of($users)
        ->add_column('actions', '{{View::make("users.actions-row", compact("id", "confirmed"))->render()}}')
        ->edit_column('confirmed', '{{ $confirmed ? \'Yes\' : \'No\' }}')
				->remove_column('id')
				->make();
			return Datatables::of($users)->make();
		}
		return View::make('users.index');
	}

	/**
	 * Show the form for creating a new user
	 *
	 * @return Response
	 */
	public function create()
	{
		if(Request::ajax())
		{
			return Response::json("Bad request", 400);
		}

		if(!User::canCreate())
		{
			return Redirect::back()
				->with('notification:danger', $this->access_denied_message);
		}
		return View::make('users.create');
	}

	/**
	 * Store a newly created user in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), User::$rules);
		
		if(!User::canCreate())
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

		$data['confirmed'] = 1;
		$data['roles'] = isset($data['roles']) ? $data['roles'] : [];

		Event::fire('User.before.create', [$data]);

		$user = User::create($data);
		$user->roles()->sync($data['roles']);

		if(!isset($user->id))
		{
			if(Request::ajax())
			{
				return Response::json($this->create_error_message, 201);
			}
			return Redirect::back()
				->with('notification:danger', $this->create_error_message);
		}

		Event::fire('User.after.create', [$user]);

		if(Request::ajax())
		{
			return Response::json($user->toJson(), 201);
		}
		return Redirect::route('users.index')
			->with('notification:success', $this->created_message);
	}

	/**
	 * Display the specified user.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user = User::findOrFail($id);
		
		if(!$user->canShow())
		{
			if(Request::ajax())
			{
				return Response::json($this->access_denied_message, 403);
			}
			return Redirect::back()->with('notification:danger', $this->access_denied_message);
		}

		if(Request::ajax())
		{
			return Response::json($user->toJson(), 201);
		}
		return View::make('users.show', compact('user'));
	}

	/**
	 * Show the form for editing the specified user.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = User::find($id);

		if(Request::ajax())
		{
			return Response::json("Bad request", 400);
		}
		
		if(!$user->canUpdate())
		{
			return Redirect::back()->with('notification:danger', $this->access_denied_message);
		}

		return View::make('users.edit', compact('user'));
	}

	/**
	 * Update the specified user in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$user = User::findOrFail($id);
		$data = Input::all();
		
		if(!$user->canUpdate())
		{
			if(Request::ajax())
			{
				return Response::json($this->access_denied_message, 403);
			}
			return Redirect::back()
				->with('notification:danger', $this->access_denied_message);
		}

		User::$rules['username'] = User::$rules['username'] . ',' . $id;
		User::$rules['email'] = User::$rules['email'] . ',' . $id;
		unset(User::$rules['password']);
		unset(User::$rules['password_confirmation']);
		$validator = Validator::make($data, User::$rules);

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
		$data['roles'] = isset($data['roles']) ? $data['roles'] : [];
		$user->roles()->sync($data['roles']);

		Event::fire('User.before.update', [$user]);

		if(!$user->update($data)){
			if(Request::ajax())
			{
				return Response::json($this->update_error_message, 500);
			}
			return Redirect::back()
				->withErrors($validator)
				->withInput()
				->with('notification:danger', $this->update_error_message);
		}

		Event::fire('User.after.update', [$user]);

		if(Request::ajax())
		{
			return $user;
		}
		return Redirect::back()
			->with('notification:success', $this->updated_message);
	}

	/**
	 * Remove the specified user from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$user = User::findOrFail($id);
		
		if(!$user->canDelete())
		{
			if(Request::ajax())
			{
				return Response::json($this->access_denied_message, 403);
			}
			return Redirect::back()->with('notification:danger', $this->access_denied_message);
		}

		Event::fire('User.before.delete', [$user]);

		if(!$user->delete()){
			if(Request::ajax())
			{
				return Response::json($this->delete_error_message, 500);
			}
			return Redirect::back()
				->withErrors($validator)
				->withInput()
				->with('notification:danger', $this->delete_error_message);
		}

		Event::fire('User.after.update', [$user]);

		if(Request::ajax())
		{
			return Response::json($this->deleted_message);
		}

		return Redirect::route('users.index')
			->with('notification:success', $this->deleted_message);
	}

	/**
	 * ====================================================================================================================
	 * Additional methods
	 * ====================================================================================================================
	 */

	public function profile()
	{
		return View::make('users.profile', ['controller' => 'Profile']);	
	}

	public function getSetPassword()
	{
		$user = User::findOrFail($id);
		if(Request::ajax())
		{
			return Response::json($this->access_denied_message, 403);
		}
		if(!$user->canSetPassword())
		{
			return Redirect::back()
				->with('notification:danger', $this->access_denied_message);
		}
		return View::make('users.set-password', compact('user'));
	}

	public function putSetPassword()
	{
		$user = User::findOrFail($id);
		$data = Input::all();
		if(!$user->canSetPassword())
		{
			if(Request::ajax())
			{
				return Response::json($this->access_denied_message, 403);
			}
			return Redirect::back()
				->with('notification:danger', $this->access_denied_message);
		}

		User::$rules = [
      'password' => 'required|min:4|confirmed',
      'password_confirmation' => 'min:4' 
    ];

		$validator = Validator::make($data, User::$rules);

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

		Event::fire('User.before.update', [$user]);

		if(!$user->update($data)){
			if(Request::ajax())
			{
				return Response::json($this->set_password_error_message, 500);
			}
			return Redirect::back()
				->withErrors($validator)
				->withInput()
				->with('notification:danger', $this->update_error_message);
		}

		Event::fire('User.after.update', [$user]);

		if(Request::ajax())
		{
			return Response::json($this->set_password_message);
		}
		return Redirect::action('users.show', $user->id)
			->with('notification:success', $this->set_password_message);
	}

	public function putSetConfirmation($id = null)
	{
		$user = User::findOrFail($id);
		$data = Input::all();
		if(!$user->canSetConfirmation())
		{
			if(Request::ajax())
			{
				return Response::json($this->access_denied_message, 403);
			}
			return Redirect::back()
				->with('notification:danger', $this->access_denied_message);
		}

		User::$rules = [
      'confirmed' => 'numeric|min:0|max:1',
    ];

		$validator = Validator::make($data, User::$rules);

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

		Event::fire('User.before.update', [$user]);

		if(!$user->update($data)){
			if(Request::ajax())
			{
				return Response::json($this->set_confirmation_error_message, 500);
			}
			return Redirect::back()
				->withErrors($validator)
				->withInput()
				->with('notification:danger', $this->set_confirmation_error_message);
		}

		Event::fire('User.after.update', [$user]);

		if(Request::ajax())
		{
			return Response::json($this->set_confirmation_message);
		}
		return Redirect::action('users.show', $user->id)
			->with('notification:success', $this->set_confirmation_message);
	}



	public function getChangePassword()
	{
		$user = Auth::user();
		if(!$user->canSetPassword())
		{
			if(Request::ajax())
			{
				return Response::json($this->access_denied_message, 403);
			}
			return Redirect::back()
				->with('notification:danger', $this->access_denied_message);
		}
		return View::make('users.change-password', compact('user'));
	}

	public function putChangePassword()
	{
		$user = Auth::user();
		$data = Input::all();
		if(!$user->canSetPassword())
		{
			if(Request::ajax())
			{
				return Response::json($this->access_denied_message, 403);
			}
			return Redirect::back()
				->with('notification:danger', $this->access_denied_message);
		}

		User::$rules = [
      'old_password' => 'required|min:4',
      'password' => 'required|min:4|confirmed',
      'password_confirmation' => 'min:4' 
    ];

		$validator = Validator::make($data, User::$rules);

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

		if(!Hash::check($data['old_password'], $user->password))
		{
			if(Request::ajax())
			{
				return Response::json($this->change_password_invalid_message, 500);
			}
			return Redirect::back()
				->withErrors($validator)
				->withInput()
				->with('notification:danger', $this->change_password_invalid_message);
		}

		Event::fire('User.before.update', [$user]);

		if(!$user->update($data)){
			if(Request::ajax())
			{
				return Response::json($this->set_password_error_message, 500);
			}
			return Redirect::back()
				->withErrors($validator)
				->withInput()
				->with('notification:danger', $this->update_error_message);
		}

		Event::fire('User.after.update', [$user]);

		if(Request::ajax())
		{
			return Response::json($this->set_password_message);
		}
		return Redirect::action('UsersController@profile', $user->id)
			->with('notification:success', $this->set_password_message);
	}

	public function __construct()
	{
		parent::__construct();
		View::share('controller', 'UsersController');
	}

}
