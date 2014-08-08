<?php

class PermissionsController extends \BaseController
{

    /**
     * Display a listing of permissions
     *
     * @return Response
     */
    public function index()
    {
        if (!Permission::canList()) {
            return $this->_access_denied();
        }
        if (Request::ajax()) {
            $permissions = Permission::select(['id', 'group_name', 'name', 'display_name']);
            return Datatables::of($permissions)
                ->add_column('actions', '{{View::make("permissions.actions-row", compact("id"))->render()}}')
                ->remove_column('id')
                ->make();
        }
        Asset::push('js', 'datatables');
        return View::make('permissions.index');
    }

    /**
     * Show the form for creating a new permission
     *
     * @return Response
     */
    public function create()
    {
        if (Request::ajax()) {
            return _ajax_denied();
        }
        if (!Permission::canCreate()) {
            return $this->_access_denied();
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
        if (!Permission::canCreate()) {
            return _access_denied();
        }
        Permission::setRules('store');
        $permission = new Permission;
        $permission->fill(Input::all());
        if (!$permission->save()) {
            return $this->_validation_error($permission);
        }
        if (Request::ajax()) {
            return Response::json($permission, 201);
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
        if (!$permission->canShow()) {
            return _access_denied();
        }
        if (Request::ajax()) {
            return $permission;
        }
        Asset::push('js', 'show');
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
        if (Request::ajax()) {
            return _ajax_denied();
        }
        if (!$permission->canUpdate()) {
            return _access_denied();
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
        Permission::setRules('update');
        if (!$permission->canUpdate()) {
            return _access_denied();
        }
        $permission->fill(Input::all());
        if (!$permission->updateUniques()) {
            return $this->_validation_error($permission);
        }
        if (Request::ajax()) {
            return $permission;
        }
        Session::remove('_old_input');
        return Redirect::route('permissions.edit', $id)
            ->with('notification:success', $this->updated_message);
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
        if (!$permission->canDelete()) {
            return _access_denied();
        }
        if (!$permission->delete()) {
            return $this->_delete_error();
        }
        if (Request::ajax()) {
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
