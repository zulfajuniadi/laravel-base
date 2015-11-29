<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\AuthLogsRepository;
use App\Http\Controllers\Controller;
use yajra\Datatables\Html\Builder;
use App\AuthLog;

class AuthLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $htmlBuilder)
    {
        $DataTable = $htmlBuilder
            ->addColumn(['data' => 'created_at', 'name' => 'auth_logs.created_at', 'title' => trans('auth-logs.created_at')])
            ->addColumn(['data' => 'user_name', 'name' => 'users.name', 'title' => trans('users.name')])
            ->addColumn(['data' => 'ip_address', 'name' => 'ip_address', 'title' => trans('auth-logs.ip_address')])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => trans('auth-logs.action')])
            ->ajax(action('AuthLogsController@data'));
        return view()->make('auth-logs.index', compact('DataTable'));
    }

    /**
     * Data listing of the resource for DataTables.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        return app('datatables')
            ->of(AuthLog::select('auth_logs.*', 'users.name as user_name')
                    ->leftJoin('users', 'users.id', '=', 'auth_logs.user_id'))
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view()->make('auth-logs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $authLog = AuthLogsRepository::create(new AuthLog, $request->all());
        return redirect()
            ->action('AuthLogsController@index')
            ->with('success', trans('auth-logs.created', ['name' => $authLog->name]));
    }

    /**
     * Display the specified resource.
     *
     * @param  AuthLog  $authLog
     * @return \Illuminate\Http\Response
     */
    public function show(AuthLog $authLog)
    {
        return view()->make('auth-logs.show', compact('authLog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  AuthLog  $authLog
     * @return \Illuminate\Http\Response
     */
    public function edit(AuthLog $authLog)
    {
        return view()->make('auth-logs.edit', compact('authLog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  AuthLog  $authLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AuthLog $authLog)
    {
        $authLog = AuthLogsRepository::update($authLog, $request->all());
        return redirect()
            ->action('AuthLogsController@index')
            ->with('success', trans('auth-logs.updated', ['name' => $authLog->name]));
    }

    /**
     * Duplicates the specified resource.
     *
     * @param  AuthLog  $authLog
     * @return \Illuminate\Http\Response
     */
    public function duplicate(AuthLog $authLog)
    {
        $authLog->name = $authLog->name . '-' . str_random(4);
        $authLog = AuthLogsRepository::duplicate($authLog);
        return redirect()
            ->action('AuthLogsController@edit', $authLog->slug)
            ->with('success', trans('auth-logs.created', ['name' => $authLog->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  AuthLog  $authLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(AuthLog $authLog)
    {
        AuthLogsRepository::delete($authLog);
        return redirect()
            ->action('AuthLogsController@index')
            ->with('success', trans('auth-logs.deleted', ['name' => $authLog->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  AuthLog  $authLog
     * @return \Illuminate\Http\Response
     */
    public function delete(AuthLog $authLog)
    {
        return $this->destroy($authLog);
    }

    /**
     * Displays the revisions of the specified resource.
     *
     * @param  AuthLog  $authLog
     * @return \Illuminate\Http\Response
     */
    public function revisions(AuthLog $authLog)
    {
        return view()->make('auth-logs.revisions', compact('authLog'));
    }

    public function __construct()
    {
        $this->middleware('title');
        $this->middleware('menu');
        $this->middleware('policy');
        $this->middleware('validate');
    }
}
