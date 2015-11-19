<?php

namespace App\Menus;

class RolesMenu extends BaseMenu
{

    protected $controller = 'App\Http\Controllers\RolesController';

    public function index($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('RolesController@index'), trans('roles.roles'));
        $this->menu->handler('roles.panel-buttons')
            ->addClass('pull-right')
            ->addItemIf(app('policy')->check($this->controller, 'create'), action('RolesController@create'), trans('roles.create'), 'btn btn-primary');
    }

    public function create($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('RolesController@index'), trans('roles.roles'))
            ->addItem(action('RolesController@create'), trans('roles.create'));
        $this->menu->handler('roles.panel-buttons.create')
            ->addClass('pull-right')
            ->addItemIf(app('policy')->check($this->controller, 'index'), action('RolesController@index'), trans('roles.list_all'), 'btn btn-primary');
    }

    public function show($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('RolesController@index'), trans('roles.roles'))
            ->addItem(action('RolesController@show', $params['roles']->slug), $params['roles']->display_name);
        $this->menu->handler('roles.panel-buttons.show')
            ->addClass('pull-right')
            ->addItemIf(app('policy')->check($this->controller, 'index'), action('RolesController@index'), trans('roles.list_all'), 'btn btn-primary')
            ->addItemIf(app('policy')->check($this->controller, 'create'), action('RolesController@create'), trans('roles.create'), 'btn btn-default');
        $this->menu->handler('roles.record-buttons.show')
            ->addItemIf(app('policy')->check($this->controller, 'edit', $params), action('RolesController@edit', $params['roles']->slug), trans('roles.edit'), 'btn btn-primary')
            ->addItemIf(app('policy')->check($this->controller, 'revisions', $params), action('RolesController@revisions', $params['roles']->slug), trans('roles.revisions'), 'btn btn-default')
            ->addItemIf(app('policy')->check($this->controller, 'duplicate', $params), action('RolesController@duplicate', $params['roles']->slug),  trans('roles.duplicate'), 'btn btn-default')
            ->addItemIf(app('policy')->check($this->controller, 'delete', $params), action('RolesController@delete', $params['roles']->slug), trans('roles.delete'), 'btn btn-danger confirm-action');
    }

    public function edit($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('RolesController@index'), trans('roles.roles'))
            ->addItem(action('RolesController@show', $params['roles']->slug), $params['roles']->display_name);
        $this->menu->handler('roles.panel-buttons.edit')
            ->addClass('pull-right')
            ->addItemIf(app('policy')->check($this->controller, 'index'), action('RolesController@index'), trans('roles.list_all'), 'btn btn-primary');
        $this->menu->handler('roles.record-buttons.edit')
            ->addItemIf(app('policy')->check($this->controller, 'show'), action('RolesController@show', $params['roles']->slug), trans('roles.show'), 'btn btn-default');
    }

    public function revisions($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('RolesController@index'), trans('roles.roles'))
            ->addItem(action('RolesController@show', $params['roles']->slug), $params['roles']->display_name)
            ->addItem(action('RolesController@revisions', $params['roles']->slug), 'Revisions');
        $this->menu->handler('roles.panel-buttons.revisions')
            ->addClass('pull-right')
            ->addItemIf(app('policy')->check($this->controller, 'index'), action('RolesController@index'), trans('roles.list_all'), 'btn btn-primary')
            ->addItemIf(app('policy')->check($this->controller, 'show'), action('RolesController@show', $params['roles']->slug), trans('roles.show'), 'btn btn-default');
    }

    public function __construct()
    {
        parent::__construct();
        $this->menu->handler('admin')
            ->addItemIf(app('policy')->check($this->controller, 'index'), action('RolesController@index'), trans('roles.roles'));
    }

}