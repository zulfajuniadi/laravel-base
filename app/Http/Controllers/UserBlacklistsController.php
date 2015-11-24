<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\UserBlacklistsRepository;
use App\Http\Controllers\Controller;
use yajra\Datatables\Html\Builder;
use App\UserBlacklist;
use App\User;

class UserBlacklistsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $htmlBuilder, User $user)
    {
        $DataTable = $htmlBuilder
            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => trans('user-blacklists.name')])
            ->addColumn(['data' => 'until', 'name' => 'until', 'title' => trans('user-blacklists.until')])
            ->ajax(action('UserBlacklistsController@data', $user->slug));
        return view()->make('user-blacklists.index', compact('DataTable', 'user'));
    }

    /**
     * Data listing of the resource for DataTables.
     *
     * @return \Illuminate\Http\Response
     */
    public function data(User $user)
    {
        return app('datatables')
            ->of(UserBlacklist::where('user_id', $user->id))
            ->editColumn('name', function($userBlacklist) use ($user) {
                if(app('policy')->check('App\Http\Controllers\UserBlacklistsController', 'show', [$userBlacklist->slug])) {
                    return link_to_action('UserBlacklistsController@show', $userBlacklist->name, [$user->slug, $userBlacklist->slug]);
                }
                return $userBlacklist->name;
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {
        return view()->make('user-blacklists.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $data = $request->all();
        $data['user_id'] = $user->id;
        $userBlacklist = UserBlacklistsRepository::create(new UserBlacklist, $data);
        return redirect()
            ->action('UserBlacklistsController@index', $user->slug)
            ->with('success', trans('user-blacklists.created', ['name' => $userBlacklist->name]));
    }

    /**
     * Display the specified resource.
     *
     * @param  UserBlacklist  $userBlacklist
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, UserBlacklist $userBlacklist)
    {
        return view()->make('user-blacklists.show', compact('userBlacklist'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  UserBlacklist  $userBlacklist
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, UserBlacklist $userBlacklist)
    {
        return view()->make('user-blacklists.edit', compact('userBlacklist', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  UserBlacklist  $userBlacklist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, UserBlacklist $userBlacklist)
    {
        $userBlacklist = UserBlacklistsRepository::update($userBlacklist, $request->all());
        return redirect()
            ->action('UserBlacklistsController@index', $user->slug)
            ->with('success', trans('user-blacklists.updated', ['name' => $userBlacklist->name]));
    }

    /**
     * Duplicates the specified resource.
     *
     * @param  UserBlacklist  $userBlacklist
     * @return \Illuminate\Http\Response
     */
    public function duplicate(User $user, UserBlacklist $userBlacklist)
    {
        $userBlacklist->name = $userBlacklist->name . '-' . str_random(4);
        $userBlacklist = UserBlacklistsRepository::duplicate($userBlacklist);
        return redirect()
            ->action('UserBlacklistsController@edit', [$user->slug, $userBlacklist->slug])
            ->with('success', trans('user-blacklists.created', ['name' => $userBlacklist->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  UserBlacklist  $userBlacklist
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, UserBlacklist $userBlacklist)
    {
        UserBlacklistsRepository::delete($userBlacklist);
        return redirect()
            ->action('UserBlacklistsController@index', $user->slug)
            ->with('success', trans('user-blacklists.deleted', ['name' => $userBlacklist->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  UserBlacklist  $userBlacklist
     * @return \Illuminate\Http\Response
     */
    public function delete(User $user, UserBlacklist $userBlacklist)
    {
        return $this->destroy($user, $userBlacklist);
    }

    /**
     * Displays the revisions of the specified resource.
     *
     * @param  UserBlacklist  $userBlacklist
     * @return \Illuminate\Http\Response
     */
    public function revisions(User $user, UserBlacklist $userBlacklist)
    {
        return view()->make('user-blacklists.revisions', compact('userBlacklist'));
    }

    public function __construct()
    {
        $this->middleware('title');
        $this->middleware('menu');
        $this->middleware('policy');
        $this->middleware('validate');
    }
}
