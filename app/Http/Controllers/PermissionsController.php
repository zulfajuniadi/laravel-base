<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\PermissionsRepository;
use App\Http\Controllers\Controller;
use yajra\Datatables\Html\Builder;
use App\Permission;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $htmlBuilder)
    {
        $DataTable = $htmlBuilder
            ->addColumn(['data' => 'permission_group_name', 'name' => 'permission_groups.name', 'title' => trans('permissions.permission_group_id')])
            ->addColumn(['data' => 'display_name', 'name' => 'display_name', 'title' => trans('permissions.display_name')])
            ->ajax(action('PermissionsController@data'));
        return view()->make('permissions.index', compact('DataTable'));
    }

    /**
     * Data listing of the resource for DataTables.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        return app('datatables')
            ->of(Permission::select('permissions.*', 'permission_groups.name as permission_group_name')
                    ->leftJoin('permission_groups', 'permission_groups.id', '=', 'permissions.permission_group_id'))
            ->editColumn('name', function($permission){
                if(app('policy')->check('App\Http\Controllers\PermissionsController', 'show', [$permission->slug])) {
                    return link_to_action('PermissionsController@show', $permission->name, $permission->slug);
                }
                return $permission->name;
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view()->make('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $permission = PermissionsRepository::create(new Permission, $request->all());
        return redirect()
            ->action('PermissionsController@index')
            ->with('success', trans('permissions.created', ['name' => $permission->name]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        return view()->make('permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return view()->make('permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $permission = PermissionsRepository::update($permission, $request->all());
        return redirect()
            ->action('PermissionsController@index')
            ->with('success', trans('permissions.updated', ['name' => $permission->name]));
    }

    /**
     * Duplicates the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function duplicate(Permission $permission)
    {
        $permission->name = $permission->name . '-' . str_random(4);
        $permission = PermissionsRepository::duplicate($permission);
        return redirect()
            ->action('PermissionsController@edit', $permission->slug)
            ->with('success', trans('permissions.created', ['name' => $permission->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        PermissionsRepository::delete($permission);
        return redirect()
            ->action('PermissionsController@index')
            ->with('success', trans('permissions.deleted', ['name' => $permission->name]));
    }

    public function delete(Permission $permission)
    {
        return $this->destroy($permission);
    }

    public function revisions(Permission $permission)
    {
        return view()->make('permissions.revisions', compact('permission'));
    }

    public function __construct()
    {
        $this->middleware('title');
        $this->middleware('menu');
        $this->middleware('policy');
        $this->middleware('validate');
    }
}
