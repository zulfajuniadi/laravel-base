<?php

namespace App\Menus;

use App\Libraries\Menu\BaseMenu;
use App\Http\Controllers\ModelNamesController;

class ModelNamesMenu extends BaseMenu
{

    protected $controller = ModelNamesController::class;

    public function index($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('ParentNamesController@index'), trans('parent-names.parent_names'))
            ->addItem(action('ParentNamesController@show', ['parent_names' => $params['parent_names']->getSlug()]), $params['parent_names']->name)
            ->addItem(action('ModelNamesController@index', ['parent_names' => $params['parent_names']->getSlug()]), trans('model-names.model_names'))
            ;
        $this->menu->handler('model-names.panel-buttons')
            ->addClass('pull-right')
            ->addItemIf($this->check('show', [$params['parent_names']], 'App\Http\Controllers\ParentNamesController'), action('ParentNamesController@show', ['parent_names' => $params['parent_names']->getSlug()]), $params['parent_names']->name, 'btn btn-default')
            ->addItemIf($this->check('create', [$params['parent_names']]), action('ModelNamesController@create', ['parent_names' => $params['parent_names']->getSlug()]), trans('model-names.create'), 'btn btn-primary')
            ;
    }

    public function create($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('ParentNamesController@index'), trans('parent-names.parent_names'))
            ->addItem(action('ParentNamesController@show', ['parent_names' => $params['parent_names']->getSlug()]), $params['parent_names']->name)
            ->addItem(action('ModelNamesController@index', ['parent_names' => $params['parent_names']->getSlug()]), trans('model-names.model_names'))
            ->addItem(action('ModelNamesController@create', ['parent_names' => $params['parent_names']->getSlug()]), trans('model-names.create'))
            ;
        $this->menu->handler('model-names.panel-buttons.create')
            ->addClass('pull-right')
            ->addItemIf($this->check('index', [$params['parent_names']]), action('ModelNamesController@index', ['parent_names' => $params['parent_names']->getSlug()]), trans('model-names.list_all'), 'btn btn-primary')
            ;
    }

    public function show($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('ParentNamesController@index'), trans('parent-names.parent_names'))
            ->addItem(action('ParentNamesController@show', ['parent_names' => $params['parent_names']->getSlug()]), $params['parent_names']->name)
            ->addItem(action('ModelNamesController@index', ['parent_names' => $params['parent_names']->getSlug()]), trans('model-names.model_names'))
            ->addItem(action('ModelNamesController@show', ['parent_names' => $params['parent_names']->getSlug(), 'model_names' => $params['model_names']->getSlug()]), $params['model_names']->name)
            ;
        $this->menu->handler('model-names.panel-buttons.show')
            ->addClass('pull-right')
            ->addItemIf($this->check('index', [$params['parent_names']]), action('ModelNamesController@index', [$params['parent_names']->getSlug()]), trans('model-names.list_all'), 'btn btn-primary')
            ->addItemIf($this->check('create', [$params['parent_names']]), action('ModelNamesController@create', [$params['parent_names']->getSlug()]), trans('model-names.create'), 'btn btn-default')
            ;
        $this->menu->handler('model-names.record-buttons.show')
            ->addItemIf($this->check('edit', [$params['parent_names'], $params['model_names']]), action('ModelNamesController@edit', [$params['parent_names']->getSlug(), $params['model_names']->getSlug()]), trans('model-names.edit'), 'btn btn-primary')
            ->addItemIf($this->check('revisions', [$params['parent_names'], $params['model_names']]), action('ModelNamesController@revisions', [$params['parent_names']->getSlug(), $params['model_names']->getSlug()]), trans('model-names.revisions'), 'btn btn-default')
            ->addItemIf($this->check('duplicate', [$params['parent_names'], $params['model_names']]), action('ModelNamesController@duplicate', [$params['parent_names']->getSlug(), $params['model_names']->getSlug()]),  trans('model-names.duplicate'), 'btn btn-default')
            ->addItemIf($this->check('delete', [$params['parent_names'], $params['model_names']]), action('ModelNamesController@delete', [$params['parent_names']->getSlug(), $params['model_names']->getSlug()]), trans('model-names.delete'), 'btn btn-danger confirm-action')
            ;
    }

    public function edit($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('ParentNamesController@index'), trans('parent-names.parent_names'))
            ->addItem(action('ParentNamesController@show', ['parent_names' => $params['parent_names']->getSlug()]), $params['parent_names']->name)
            ->addItem(action('ModelNamesController@index', ['parent_names' => $params['parent_names']->getSlug()]), trans('model-names.model_names'))
            ->addItem(action('ModelNamesController@show', ['parent_names' => $params['parent_names']->getSlug(), 'model_names' => $params['model_names']->getSlug()]), $params['model_names']->name)
            ;
        $this->menu->handler('model-names.panel-buttons.edit')
            ->addClass('pull-right')
            ->addItemIf($this->check('index', [$params['parent_names']]), action('ModelNamesController@index', [$params['parent_names']->getSlug()]), trans('model-names.list_all'), 'btn btn-primary')
            ;
        $this->menu->handler('model-names.record-buttons.edit')
            ->addItemIf($this->check('show', [$params['parent_names'], $params['model_names']]), action('ModelNamesController@show', [$params['parent_names']->getSlug(), $params['model_names']->getSlug()]), trans('model-names.show'), 'btn btn-default')
            ;
    }

    public function revisions($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('ParentNamesController@index'), trans('parent-names.parent_names'))
            ->addItem(action('ParentNamesController@show', ['parent_names' => $params['parent_names']->getSlug()]), $params['parent_names']->name)
            ->addItem(action('ModelNamesController@index', ['parent_names' => $params['parent_names']->getSlug()]), trans('model-names.model_names'))
            ->addItem(action('ModelNamesController@show', ['parent_names' => $params['parent_names']->getSlug(), 'model_names' => $params['model_names']->getSlug()]), $params['model_names']->name)
            ->addItem(action('ModelNamesController@revisions', [$params['parent_names']->getSlug(), $params['model_names']->getSlug()]), trans('model-names.revisions'))
            ;
        $this->menu->handler('model-names.panel-buttons.revisions')
            ->addClass('pull-right')
            ->addItemIf($this->check('index', [$params['parent_names']]), action('ModelNamesController@index', [$params['parent_names']->getSlug()]), trans('model-names.list_all'), 'btn btn-primary')
            ->addItemIf($this->check('show', [$params['parent_names'], $params['model_names']]), action('ModelNamesController@show', [$params['parent_names']->getSlug(), $params['model_names']->getSlug()]), trans('model-names.show'), 'btn btn-default')
            ;
    }

    public function __construct()
    {
        parent::__construct();
    }

}