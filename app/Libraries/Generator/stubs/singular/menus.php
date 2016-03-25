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
            ->addItem(action('ModelNamesController@index'), trans('model-names.model_names'));
        $this->menu->handler('model-names.panel-buttons')
            ->addClass('pull-right')
            ->addItemIf($this->check('create'), action('ModelNamesController@create'), trans('model-names.create'), 'btn btn-primary');
    }

    public function create($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('ModelNamesController@index'), trans('model-names.model_names'))
            ->addItem(action('ModelNamesController@create'), trans('model-names.create'));
        $this->menu->handler('model-names.panel-buttons.create')
            ->addClass('pull-right')
            ->addItemIf($this->check('index'), action('ModelNamesController@index'), trans('model-names.list_all'), 'btn btn-primary');
    }

    public function show($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('ModelNamesController@index'), trans('model-names.model_names'))
            ->addItem(action('ModelNamesController@show', $params['model_names']->getSlug()), $params['model_names']->name);
        $this->menu->handler('model-names.panel-buttons.show')
            ->addClass('pull-right')
            ->addItemIf($this->check('index'), action('ModelNamesController@index'), trans('model-names.list_all'), 'btn btn-primary')
            ->addItemIf($this->check('create'), action('ModelNamesController@create'), trans('model-names.create'), 'btn btn-default');
        $this->menu->handler('model-names.record-buttons.show')
            ->addItemIf($this->check('edit', $params), action('ModelNamesController@edit', $params['model_names']->getSlug()), trans('model-names.edit'), 'btn btn-primary')
            ->addItemIf($this->check('revisions', $params), action('ModelNamesController@revisions', $params['model_names']->getSlug()), trans('model-names.revisions'), 'btn btn-default')
            ->addItemIf($this->check('duplicate', $params), action('ModelNamesController@duplicate', $params['model_names']->getSlug()),  trans('model-names.duplicate'), 'btn btn-default')
            ->addItemIf($this->check('delete', $params), action('ModelNamesController@delete', $params['model_names']->getSlug()), trans('model-names.delete'), 'btn btn-danger confirm-action');
    }

    public function edit($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('ModelNamesController@index'), trans('model-names.model_names'))
            ->addItem(action('ModelNamesController@show', $params['model_names']->getSlug()), $params['model_names']->name);
        $this->menu->handler('model-names.panel-buttons.edit')
            ->addClass('pull-right')
            ->addItemIf($this->check('index'), action('ModelNamesController@index'), trans('model-names.list_all'), 'btn btn-primary');
        $this->menu->handler('model-names.record-buttons.edit')
            ->addItemIf($this->check('show', [$params['model_names']]), action('ModelNamesController@show', $params['model_names']->getSlug()), trans('model-names.show'), 'btn btn-default');
    }

    public function revisions($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('ModelNamesController@index'), trans('model-names.model_names'))
            ->addItem(action('ModelNamesController@show', $params['model_names']->getSlug()), $params['model_names']->name)
            ->addItem(action('ModelNamesController@revisions', $params['model_names']->getSlug()), trans('model-names.revisions'));
        $this->menu->handler('model-names.panel-buttons.revisions')
            ->addClass('pull-right')
            ->addItemIf($this->check('index'), action('ModelNamesController@index'), trans('model-names.list_all'), 'btn btn-primary')
            ->addItemIf($this->check('show', [$params['model_names']]), action('ModelNamesController@show', $params['model_names']->getSlug()), trans('model-names.show'), 'btn btn-default');
    }

    public function __construct()
    {
        parent::__construct();
        $this->menu->handler('app')
            ->addItemIf($this->check('index'), action('ModelNamesController@index'), trans('model-names.model_names'));
    }

}