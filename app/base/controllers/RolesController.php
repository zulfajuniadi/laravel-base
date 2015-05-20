<?php

class RolesController extends \BaseController
{

    /**
     * Display a listing of roles
     *
     * @return Response
     */
    public function index()
    {
        if (!Role::canList()) {
            return $this->_access_denied();
        }
        if (Request::ajax()) {
            $roles = Role::with('users', 'perms')
                ->select(['roles.id', 'roles.name', 'roles.id as permissions', 'roles.id as user_count', 'roles.id as actions']);
            return Datatables::of($roles)
                ->edit_column('actions', function($role){
                    $actions   = [];
                    $actions[] = $role->canShow() ? link_to_action('roles.show', 'Show', $role->id, ['class' => 'btn btn-xs btn-primary'] ) : '';
                    $actions[] = $role->canUpdate() ? link_to_action('roles.edit', 'Update', $role->id, ['class' => 'btn btn-xs btn-default'] ) : '';
                    $actions[] = $role->canDelete() ? Former::open(action('roles.destroy', $role->id))->class('form-inline') 
                        . Former::hidden('_method', 'DELETE')
                        . '<button type="button" class="btn btn-danger btn-xs confirm-delete">Delete</button>'
                        . Former::close() : '';
                    return implode(' ', $actions);
                })
                ->edit_column('user_count', function($role){
                    return $role->users->count();
                })
                ->edit_column('permissions', function($role){
                    return '<ul>' . implode('', array_map(function($name){ return '<li>' . $name . '</li>'; }, $role->perms->lists('name'))) . '</ul>';
                })
                ->remove_column('id')
                ->make();
        }
        Asset::push('js', 'datatables');
        return View::make('roles.index');
    }

    /**
     * Show the form for creating a new role
     *
     * @return Response
     */
    public function create()
    {
        if (Request::ajax()) {
            return $this->_ajax_denied();
        }
        if (!Role::canCreate()) {
            return $this->_access_denied();
        }
        Breadcrumbs::push(action('RolesController@create'), 'Create');
        return View::make('roles.create');
    }

    /**
     * Store a newly created role in storage.
     *
     * @return Response
     */
    public function store()
    {
        $data = Input::all();
        if (!Role::canCreate()) {
            return $this->_access_denied();
        }
        Role::setRules('store');
        $role = new Role;
        $role->fill($data);
        if (!$role->save()) {
            return $this->_validation_error($role);
        }
        $data['perms'] = isset($data['perms'])?$data['perms']:[];
        $role->perms()->sync($data['perms']);
        if (Request::ajax()) {
            return Response::json($role, 201);
        }
        return Redirect::route('roles.index')
            ->with('notification:success', $this->created_message);
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
        if (!$role->canShow()) {
            return $this->_access_denied();
        }
        if (Request::ajax()) {
            return $role;
        }
        Asset::push('js', 'show');
        Breadcrumbs::push(action('RolesController@show', $id), $role->name);
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
        if (Request::ajax()) {
            return $this->_ajax_denied();
        }
        if (!$role->canUpdate()) {
            return $this->_access_denied();
        }
        Breadcrumbs::push(action('RolesController@edit', $id), 'Edit ' . $role->name);
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
        $data = Input::all();
        Role::setRules('update');
        if (!$role->canUpdate()) {
            return $this->_ajax_denied();
        }
        $role->fill($data);
        if (!$role->updateUniques()) {
            return $this->_validation_error($role);
        }
        $data['perms'] = isset($data['perms'])?$data['perms']:[];
        $role->perms()->sync($data['perms']);
        $role->touch();
        if (Request::ajax()) {
            return $role;
        }
        Session::remove('_old_input');
        return Redirect::route('roles.edit', $id)
            ->with('notification:success', $this->updated_message);
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
        if (!$role->canDelete()) {
            return $this->_access_denied();
        }
        if (!$role->delete()) {
            return $this->_delete_error();
        }
        if (Request::ajax()) {
            return Response::json($this->deleted_message);
        }
        return Redirect::route('roles.index')
            ->with('notification:success', $this->deleted_message);
    }

    public function __construct()
    {
        parent::__construct();
        Breadcrumbs::push(action('RolesController@index'), 'Roles');
        View::share('controller', 'RolesController');
    }

}
