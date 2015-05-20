<?php

class UsersController extends \BaseController
{

    public $set_password_message            = 'Password set succesfully.';
    public $set_confirmation_message        = 'Activation set succesfully.';
    public $change_password_invalid_message = 'Invalid Old Password.';
    public $change_password_message         = 'Password changed succesfully.';

    /**
     * Display a listing of users
     *
     * @return Response
     */
    public function index()
    {
        if (!User::canList()) {
            return $this->_access_denied();
        }
        if (Request::ajax()) {
            $users = User::with('roles')->whereNotNull('users.created_at');
            $users = $users
                ->select(['users.id', 'users.last_name', 'users.id as roles_column', 'users.confirmed', 'users.id as actions', 'users.first_name']);
            return Datatables::of($users)
                ->edit_column('last_name', function($user){
                    return $user->getFullName();
                })
                ->edit_column('roles_column', function($user){
                    return '<ul>' . implode('', array_map(function($name){ return '<li>' . $name . '</li>'; }, $user->roles->lists('name'))) . '</ul>';
                })
                ->edit_column('confirmed', function($user){
                    return $user->status();
                })
                ->edit_column('actions', function($data){
                    $actions   = [];
                    $actions[] = $data->canShow()   ? link_to_action('users.show', 'Show', $data->id, ['class' => 'btn btn-xs btn-primary'] ) : '';
                    $actions[] = $data->canUpdate() ? link_to_action('users.edit', 'Update', $data->id, ['class' => 'btn btn-xs btn-default'] ) : '';
                    $actions[] = $data->canDelete() ? Former::open(action('users.destroy', $data->id))->class('form-inline') 
                        . Former::hidden('_method', 'DELETE')
                        . '<button type="button" class="btn btn-danger btn-xs confirm-delete">Delete</button>'
                        . Former::close() : '';
                    return implode(' ', $actions);
                })
                ->remove_column('id')
                ->make();
        }
        Asset::push('js', 'datatables');
        return View::make('users.index');
    }

    /**
     * Show the form for creating a new user
     *
     * @return Response
     */
    public function create()
    {
        if (Request::ajax()) {
            return $this->_ajax_denied();
        }
        if (!User::canCreate()) {
            return $this->_access_denied();
        }
        Breadcrumbs::push(action('UsersController@create'), 'Create');
        return View::make('users.create');
    }

    /**
     * Store a newly created user in storage.
     *
     * @return Response
     */
    public function store()
    {
        User::setRules('store');
        $data = Input::all();
        if (!User::canCreate()) {
            return $this->_access_denied();
        }
        $data['confirmed'] = 1;
        $data['roles']     = isset($data['roles'])?$data['roles']:[];
        $user              = new User;
        $user->fill($data);
        if (!$user->save()) {
            return $this->_validation_error($user);
        }
        $user->roles()->sync($data['roles']);
        if (Request::ajax()) {
            return Response::json($user, 201);
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
        if (!$user->canShow()) {
            return $this->_access_denied();
        }
        if (Request::ajax()) {
            return $user;
        }
        Asset::push('js', 'show');
        Breadcrumbs::push(action('UsersController@show', $id), $user->getFullName());
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
        if (Request::ajax()) {
            return $this->_ajax_denied();
        }
        if (!$user->canUpdate()) {
            return $this->_access_denied();
        }
        Breadcrumbs::push(action('UsersController@edit', $id), $user->getFullName());
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
        if (!$user->canUpdate()) {
            return $this->_access_denied();
        }
        User::setRules('update');
        $user->fill($data);
        if (!$user->updateUniques()) {
            return $this->_validation_error($user);
        }
        $data['roles'] = isset($data['roles'])?$data['roles']:[];
        $user->roles()->sync($data['roles']);
        if (Request::ajax()) {
            return $user;
        }
        Session::remove('_old_input');
        return Redirect::route('users.edit', $id)
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

        if (!$user->canDelete()) {
            return $this->_access_denied();
        }
        if (!$user->delete()) {
            return $this->_delete_error();
        }
        if (Request::ajax()) {
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
        Breadcrumbs::pull('Users');
        Breadcrumbs::push(action('UsersController@profile'), 'My Profile');
        return View::make('users.profile', ['controller' => 'Profile', 'user' => Auth::user()]);
    }

    public function getSetPassword($id)
    {
        $user = User::findOrFail($id);
        if (Request::ajax()) {
            return $this->_ajax_denied();
        }
        if (!$user->canSetPassword()) {
            return $this->_access_denied();
        }
        Breadcrumbs::push(action('UsersController@edit', $id), 'Set ' . $user->getFullName() . "'s Password");
        return View::make('users.set-password', compact('user'));
    }

    public function putSetPassword($id)
    {
        $user = User::findOrFail($id);
        $data = Input::all();
        if (!$user->canSetPassword()) {
            return $this->_ajax_denied();
        }
        User::setRules('setPassword');
        if (!$user->update($data)) {
            $this->_validation_error($user);
        }
        if (Request::ajax()) {
            return Response::json($this->set_password_message);
        }
        return Redirect::action('users.show', $user->id)
            ->with('notification:success', $this->set_password_message);
    }

    public function putSetConfirmation($id = null)
    {
        $user = User::findOrFail($id);
        $data = Input::all();
        if (!$user->canSetConfirmation()) {
            return $this->_access_denied();
        }
        User::setRules('setConfirmation');
        if (!$user->update($data)) {
            return $this->_validation_error($user);
        }
        if (Request::ajax()) {
            return Response::json($this->set_confirmation_message);
        }
        return Redirect::action('users.show', $user->id)
           ->with('notification:success', $this->set_confirmation_message);
    }

    public function getChangePassword()
    {
        $user = Auth::user();
        Breadcrumbs::pull('Users');
        Breadcrumbs::push(action('UsersController@getChangePassword'), 'Change My Password');
        return View::make('users.change-password', compact('user'));
    }

    public function putChangePassword()
    {
        $user = Auth::user();
        $data = Input::all();
        User::setRules('changePassword');
        if (!Hash::check($data['old_password'], $user->password)) {
            if (Request::ajax()) {
                return Response::json($this->change_password_invalid_message, 400);
            }
            return Redirect::back()
                ->withErrors($user->validationErrors)
                ->withInput()
                ->with('notification:danger', $this->change_password_invalid_message);
        }
        if (!$user->update($data)) {
            return $this->_validation_error($user);
        }
        if (Request::ajax()) {
            return Response::json($this->set_password_message);
        }
        return Redirect::action('UsersController@profile', $user->id)
            ->with('notification:success', $this->set_password_message);
    }

    public function __construct()
    {
        parent::__construct();
        View::share('controller', 'UsersController');
        Breadcrumbs::push(action('UsersController@index'), 'Users');

    }

}
