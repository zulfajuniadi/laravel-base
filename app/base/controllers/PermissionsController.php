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
                ->add_column('actions', function($data){
                    $actions   = [];
                    $actions[] = $data->canShow() ? link_to_action('permissions.show', 'Show', $data->id, ['class' => 'btn btn-xs btn-primary'] ) : '';
                    $actions[] = $data->canUpdate() ? link_to_action('permissions.edit', 'Update', $data->id, ['class' => 'btn btn-xs btn-default'] ) : '';
                    $actions[] = $data->canDelete() ? Former::open(action('permissions.destroy', $data->id))->class('form-inline') 
                        . Former::hidden('_method', 'DELETE')
                        . '<button type="button" class="btn btn-danger btn-xs confirm-delete">Delete</button>'
                        . Former::close() : '';
                    return implode(' ', $actions);
                })
                ->remove_column('id')
                ->make();
        }
        Asset::push('js', 'datatables');
        return View::make('permissions.index');
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
        Breadcrumbs::push(action('PermissionsController@show'), $permission->name);
        return View::make('permissions.show', compact('permission'));
    }

    public function __construct()
    {
        parent::__construct();
        Breadcrumbs::push(action('PermissionsController@index'), 'Permissions');
        View::share('controller', 'PermissionsController');
    }

}
