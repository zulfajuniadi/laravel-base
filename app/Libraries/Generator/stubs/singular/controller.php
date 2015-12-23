<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\ModelNamesRepository;
use App\Http\Controllers\Controller;
use yajra\Datatables\Html\Builder;
use App\ModelName;

class ModelNamesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $htmlBuilder)
    {
        $DataTable = $htmlBuilder
INDEXCOLUMNS
            ->ajax(action('ModelNamesController@data'));
        return view()->make('model-names.index', compact('DataTable'));
    }

    /**
     * Data listing of the resource for DataTables.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        return app('datatables')
            ->of(ModelName::whereNotNull('name'))
            ->editColumn('name', function($modelName){
                if(app('policy')->check('App\Http\Controllers\ModelNamesController', 'show', [$modelName])) {
                    return link_to_action('ModelNamesController@show', $modelName->name, $modelName->getSlug());
                }
                return $modelName->name;
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
        return view()->make('model-names.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $modelName = ModelNamesRepository::create(new ModelName, $request->all());
        return redirect()
            ->action('ModelNamesController@index')
            ->with('success', trans('model-names.created', ['name' => $modelName->name]));
    }

    /**
     * Display the specified resource.
     *
     * @param  ModelName  $modelName
     * @return \Illuminate\Http\Response
     */
    public function show(ModelName $modelName)
    {
        return view()->make('model-names.show', compact('modelName'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ModelName  $modelName
     * @return \Illuminate\Http\Response
     */
    public function edit(ModelName $modelName)
    {
        return view()->make('model-names.edit', compact('modelName'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  ModelName  $modelName
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ModelName $modelName)
    {
        $modelName = ModelNamesRepository::update($modelName, $request->all());
        return redirect()
            ->action('ModelNamesController@edit', ['model_names' => $modelName->getSlug()])
            ->with('success', trans('model-names.updated', ['name' => $modelName->name]));
    }

    /**
     * Duplicates the specified resource.
     *
     * @param  ModelName  $modelName
     * @return \Illuminate\Http\Response
     */
    public function duplicate(ModelName $modelName)
    {
        $modelName->name = $modelName->name . '-' . str_random(4);
        $modelName = ModelNamesRepository::duplicate($modelName);
        return redirect()
            ->action('ModelNamesController@edit', $modelName->getSlug())
            ->with('success', trans('model-names.created', ['name' => $modelName->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ModelName  $modelName
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModelName $modelName)
    {
        ModelNamesRepository::delete($modelName);
        return redirect()
            ->action('ModelNamesController@index')
            ->with('success', trans('model-names.deleted', ['name' => $modelName->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ModelName  $modelName
     * @return \Illuminate\Http\Response
     */
    public function delete(ModelName $modelName)
    {
        return $this->destroy($modelName);
    }

    /**
     * Displays the revisions of the specified resource.
     *
     * @param  ModelName  $modelName
     * @return \Illuminate\Http\Response
     */
    public function revisions(ModelName $modelName)
    {
        return view()->make('model-names.revisions', compact('modelName'));
    }

    public function __construct()
    {
        $this->middleware('title');
        $this->middleware('menu');
        $this->middleware('policy');
        $this->middleware('validate');
    }
}
