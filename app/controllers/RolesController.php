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
            $roles = Role::select(['roles.id', 'roles.name', DB::raw('count(permissions.id) as count')])
                ->leftJoin('permission_role', 'roles.id', '=', 'permission_role.role_id')
                ->leftJoin('permissions', 'permissions.id', '=', 'permission_role.permission_id')
                ->groupBy('roles.id');
            return Datatables::of($roles)
                ->add_column('actions', '{{View::make("roles.actions-row", compact("id"))->render()}}')
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
        View::share('controller', 'RolesController');
    }

}
