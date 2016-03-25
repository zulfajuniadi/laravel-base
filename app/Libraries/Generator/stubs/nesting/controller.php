<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\ModelNamesRepository;
use App\Http\Controllers\Controller;
use yajra\Datatables\Html\Builder;
use App\ParentName;
use App\ModelName;

class ModelNamesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $htmlBuilder, ParentName $parentName)
    {
        $DataTable = $htmlBuilder
INDEXCOLUMNS
            ->ajax(action('ModelNamesController@data', ['parent_names' => $parentName->getSlug()]));
        return view()->make('model-names.index', compact('DataTable', 'parentName'));
    }

    /**
     * Data listing of the resource for DataTables.
     *
     * @return \Illuminate\Http\Response
     */
    public function data(ParentName $parentName)
    {
        return app('datatables')
            ->of(ModelName::where('parent_id', $parentName->id))
            ->editColumn('name', function($modelName) use ($parentName) {
                if(app('policy')->check('App\Http\Controllers\ModelNamesController', 'show', [$parentName, $modelName])) {
                    return link_to_action('ModelNamesController@show', $modelName->name, [$parentName->getSlug(), $modelName->getSlug()]);
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
    public function create(ParentName $parentName)
    {
        return view()->make('model-names.create', compact('parentName'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ParentName $parentName)
    {
        $modelName = ModelNamesRepository::create(new ModelName, $request->all());
        $parentName->touch();
        return redirect()
            ->action('ModelNamesController@index', ['parent_names' => $parentName->getSlug()])
            ->with('success', trans('model-names.created', ['name' => $modelName->name]));
    }

    /**
     * Display the specified resource.
     *
     * @param  ModelName  $modelName
     * @return \Illuminate\Http\Response
     */
    public function show(ParentName $parentName, ModelName $modelName)
    {
        return view()->make('model-names.show', compact('parentName', 'modelName'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ModelName  $modelName
     * @return \Illuminate\Http\Response
     */
    public function edit(ParentName $parentName, ModelName $modelName)
    {
        return view()->make('model-names.edit', compact('parentName', 'modelName'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  ModelName  $modelName
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ParentName $parentName, ModelName $modelName)
    {
        $modelName = ModelNamesRepository::update($modelName, $request->all());
        $parentName->touch();
        return redirect()
            ->action('ModelNamesController@edit', ['parent_names' => $parentName->getSlug(), 'model_names' => $modelName->getSlug()])
            ->with('success', trans('model-names.updated', ['name' => $modelName->name]));
    }

    /**
     * Duplicates the specified resource.
     *
     * @param  ModelName  $modelName
     * @return \Illuminate\Http\Response
     */
    public function duplicate(ParentName $parentName, ModelName $modelName)
    {
        $modelName->name = $modelName->name . '-' . str_random(4);
        $modelName = ModelNamesRepository::duplicate($modelName);
        $parentName->touch();
        return redirect()
            ->action('ModelNamesController@edit', ['parent_names' => $parentName->getSlug(), 'model_names' => $modelName->getSlug()])
            ->with('success', trans('model-names.created', ['name' => $modelName->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ModelName  $modelName
     * @return \Illuminate\Http\Response
     */
    public function destroy(ParentName $parentName, ModelName $modelName)
    {
        ModelNamesRepository::delete($modelName);
        $parentName->touch();
        return redirect()
            ->action('ModelNamesController@index', ['parent_names' => $parentName->getSlug()])
            ->with('success', trans('model-names.deleted', ['name' => $modelName->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ModelName  $modelName
     * @return \Illuminate\Http\Response
     */
    public function delete(ParentName $parentName, ModelName $modelName)
    {
        return $this->destroy($parentName, $modelName);
    }

    /**
     * Displays the revisions of the specified resource.
     *
     * @param  ModelName  $modelName
     * @return \Illuminate\Http\Response
     */
    public function revisions(ParentName $parentName, ModelName $modelName)
    {
        return view()->make('model-names.revisions', compact('parentName', 'modelName'));
    }

    public function __construct()
    {
        $this->middleware('title');
        $this->middleware('menu');
        $this->middleware('policy');
        $this->middleware('validate');
    }
}
