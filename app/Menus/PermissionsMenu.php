<?php

namespace App\Menus;

use App\Libraries\Menu\BaseMenu;
use App\Http\Controllers\PermissionsController;

class PermissionsMenu extends BaseMenu
{

    protected $controller = PermissionsController::class;

    public function index($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('PermissionsController@index'), trans('permissions.permissions'));
        $this->menu->handler('permissions.panel-buttons')
            ->addClass('pull-right')
            ->addItemIf($this->check('create'), action('PermissionsController@create'), trans('permissions.create'), 'btn btn-primary');
    }

    public function create($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('PermissionsController@index'), trans('permissions.permissions'))
            ->addItem(action('PermissionsController@create'), trans('permissions.create'));
        $this->menu->handler('permissions.panel-buttons.create')
            ->addClass('pull-right')
            ->addItemIf($this->check('index'), action('PermissionsController@index'), trans('permissions.list_all'), 'btn btn-primary');
    }

    public function show($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('PermissionsController@index'), trans('permissions.permissions'))
            ->addItem(action('PermissionsController@show', $params['permissions']->slug), $params['permissions']->name);
        $this->menu->handler('permissions.panel-buttons.show')
            ->addClass('pull-right')
            ->addItemIf($this->check('index'), action('PermissionsController@index'), trans('permissions.list_all'), 'btn btn-primary')
            ->addItemIf($this->check('create'), action('PermissionsController@create'), trans('permissions.create'), 'btn btn-default');
        $this->menu->handler('permissions.record-buttons.show')
            ->addItemIf($this->check('edit', $params), action('PermissionsController@edit', $params['permissions']->slug), trans('permissions.edit'), 'btn btn-primary')
            ->addItemIf($this->check('revisions', $params), action('PermissionsController@revisions', $params['permissions']->slug), trans('permissions.revisions'), 'btn btn-default')
            ->addItemIf($this->check('duplicate', $params), action('PermissionsController@duplicate', $params['permissions']->slug),  trans('permissions.duplicate'), 'btn btn-default')
            ->addItemIf($this->check('delete', $params), action('PermissionsController@delete', $params['permissions']->slug), trans('permissions.delete'), 'btn btn-danger confirm-action');
    }

    public function edit($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('PermissionsController@index'), trans('permissions.permissions'))
            ->addItem(action('PermissionsController@show', $params['permissions']->slug), $params['permissions']->name);
        $this->menu->handler('permissions.panel-buttons.edit')
            ->addClass('pull-right')
            ->addItemIf($this->check('index'), action('PermissionsController@index'), trans('permissions.list_all'), 'btn btn-primary');
        $this->menu->handler('permissions.record-buttons.edit')
            ->addItemIf($this->check('show'), action('PermissionsController@show', $params['permissions']->slug), trans('permissions.show'), 'btn btn-default');
    }

    public function revisions($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('PermissionsController@index'), trans('permissions.permissions'))
            ->addItem(action('PermissionsController@show', $params['permissions']->slug), $params['permissions']->name)
            ->addItem(action('PermissionsController@revisions', $params['permissions']->slug), trans('permissions.revisions'));
        $this->menu->handler('permissions.panel-buttons.revisions')
            ->addClass('pull-right')
            ->addItemIf($this->check('index'), action('PermissionsController@index'), trans('permissions.list_all'), 'btn btn-primary')
            ->addItemIf($this->check('show'), action('PermissionsController@show', $params['permissions']->slug), trans('permissions.show'), 'btn btn-default');
    }

    public function __construct()
    {
        parent::__construct();
        $this->menu->handler('admin')
            ->addItemIf($this->check('index'), action('PermissionsController@index'), trans('permissions.permissions'));
    }

}