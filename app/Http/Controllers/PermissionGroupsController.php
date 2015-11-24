<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\PermissionGroupsRepository;
use App\Http\Controllers\Controller;
use yajra\Datatables\Html\Builder;
use App\PermissionGroup;

class PermissionGroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $htmlBuilder)
    {
        $DataTable = $htmlBuilder
            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => trans('permission-groups.name')])
            ->ajax(action('PermissionGroupsController@data'));
        return view()->make('permission-groups.index', compact('DataTable'));
    }

    /**
     * Data listing of the resource for DataTables.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        return app('datatables')
            ->of(PermissionGroup::whereNotNull('name'))
            ->editColumn('name', function($permissionGroup){
                if(app('policy')->check('App\Http\Controllers\PermissionGroupsController', 'show', [$permissionGroup->slug])) {
                    return link_to_action('PermissionGroupsController@show', $permissionGroup->name, $permissionGroup->slug);
                }
                return $permissionGroup->name;
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
        return view()->make('permission-groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $permissionGroup = PermissionGroupsRepository::create(new PermissionGroup, $request->all());
        return redirect()
            ->action('PermissionGroupsController@index')
            ->with('success', trans('permission-groups.created', ['name' => $permissionGroup->name]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PermissionGroup $permissionGroup)
    {
        return view()->make('permission-groups.show', compact('permissionGroup'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PermissionGroup $permissionGroup)
    {
        return view()->make('permission-groups.edit', compact('permissionGroup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PermissionGroup $permissionGroup)
    {
        $permissionGroup = PermissionGroupsRepository::update($permissionGroup, $request->all());
        return redirect()
            ->action('PermissionGroupsController@index')
            ->with('success', trans('permission-groups.updated', ['name' => $permissionGroup->name]));
    }

    /**
     * Duplicates the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function duplicate(PermissionGroup $permissionGroup)
    {
        $permissionGroup->name = $permissionGroup->name . '-' . str_random(4);
        $permissionGroup = PermissionGroupsRepository::duplicate($permissionGroup);
        return redirect()
            ->action('PermissionGroupsController@edit', $permissionGroup->slug)
            ->with('success', trans('permission-groups.created', ['name' => $permissionGroup->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PermissionGroup $permissionGroup)
    {
        PermissionGroupsRepository::delete($permissionGroup);
        return redirect()
            ->action('PermissionGroupsController@index')
            ->with('success', trans('permission-groups.deleted', ['name' => $permissionGroup->name]));
    }

    public function delete(PermissionGroup $permissionGroup)
    {
        return $this->destroy($permissionGroup);
    }

    public function revisions(PermissionGroup $permissionGroup)
    {
        return view()->make('permission-groups.revisions', compact('permissionGroup'));
    }

    public function __construct()
    {
        $this->middleware('title');
        $this->middleware('menu');
        $this->middleware('policy');
        $this->middleware('validate');
    }
}
