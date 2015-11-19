<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\RoleRepository;
use App\Http\Controllers\Controller;
use yajra\Datatables\Html\Builder;
use App\Role;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $htmlBuilder)
    {
        $DataTable = $htmlBuilder
            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => 'System Name'])
            ->addColumn(['data' => 'display_name', 'name' => 'display_name', 'title' => 'Display Name'])
            ->addColumn(['data' => 'description', 'name' => 'description', 'title' => 'Description'])
            ->ajax(action('RolesController@data'));
        return view()->make('roles.index', compact('DataTable'));
    }

    /**
     * Data listing of the resource for DataTables.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        return app('datatables')
            ->of(Role::whereNotNull('name'))
            ->editColumn('name', function($role){
                if(app('policy')->check('App\Http\Controllers\RolesController', 'show', [$role->slug])) {
                    return link_to_action('RolesController@show', $role->name, $role->slug);
                }
                return $role->name;
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
        return view()->make('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = RoleRepository::create(new Role, $request->all());
        return redirect()->action('RolesController@index')->with('success', trans('roles.created', ['name' => $role->name]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view()->make('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view()->make('roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $role = RoleRepository::update($role, $request->all());
        return redirect()->action('RolesController@index')->with('success', trans('roles.updated', ['name' => $role->name]));
    }

    /**
     * Duplicates the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function duplicate(Role $role)
    {
        $role->name = $role->name . '-' . str_random(4);
        $role = RoleRepository::duplicate($role);
        return redirect()->action('RolesController@edit', $role->slug)->with('success', trans('roles.created', ['name' => $role->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        RoleRepository::delete($role);
        return redirect()->action('RolesController@index')->with('success', trans('roles.deleted', ['name' => $role->name]));
    }

    public function delete(Role $role)
    {
        return $this->destroy($role);
    }

    public function revisions(Role $role)
    {
        return view()->make('roles.revisions', compact('role'));
    }

    public function __construct()
    {
        $this->middleware('title');
        $this->middleware('menu');
        $this->middleware('policy');
        $this->middleware('validate');
    }
}
