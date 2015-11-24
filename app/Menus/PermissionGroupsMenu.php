<?php

namespace App\Menus;

use App\Libraries\Menu\BaseMenu;
use App\Http\Controllers\PermissionGroupsController;

class PermissionGroupsMenu extends BaseMenu
{

    protected $controller = PermissionGroupsController::class;

    public function index($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('PermissionGroupsController@index'), trans('permission-groups.permission_groups'));
        $this->menu->handler('permission-groups.panel-buttons')
            ->addClass('pull-right')
            ->addItemIf($this->check('create'), action('PermissionGroupsController@create'), trans('permission-groups.create'), 'btn btn-primary');
    }

    public function create($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('PermissionGroupsController@index'), trans('permission-groups.permission_groups'))
            ->addItem(action('PermissionGroupsController@create'), trans('permission-groups.create'));
        $this->menu->handler('permission-groups.panel-buttons.create')
            ->addClass('pull-right')
            ->addItemIf($this->check('index'), action('PermissionGroupsController@index'), trans('permission-groups.list_all'), 'btn btn-primary');
    }

    public function show($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('PermissionGroupsController@index'), trans('permission-groups.permission_groups'))
            ->addItem(action('PermissionGroupsController@show', $params['permission_groups']->slug), $params['permission_groups']->name);
        $this->menu->handler('permission-groups.panel-buttons.show')
            ->addClass('pull-right')
            ->addItemIf($this->check('index'), action('PermissionGroupsController@index'), trans('permission-groups.list_all'), 'btn btn-primary')
            ->addItemIf($this->check('create'), action('PermissionGroupsController@create'), trans('permission-groups.create'), 'btn btn-default');
        $this->menu->handler('permission-groups.record-buttons.show')
            ->addItemIf($this->check('edit', $params), action('PermissionGroupsController@edit', $params['permission_groups']->slug), trans('permission-groups.edit'), 'btn btn-primary')
            ->addItemIf($this->check('revisions', $params), action('PermissionGroupsController@revisions', $params['permission_groups']->slug), trans('permission-groups.revisions'), 'btn btn-default')
            ->addItemIf($this->check('duplicate', $params), action('PermissionGroupsController@duplicate', $params['permission_groups']->slug),  trans('permission-groups.duplicate'), 'btn btn-default')
            ->addItemIf($this->check('delete', $params), action('PermissionGroupsController@delete', $params['permission_groups']->slug), trans('permission-groups.delete'), 'btn btn-danger confirm-action');
    }

    public function edit($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('PermissionGroupsController@index'), trans('permission-groups.permission_groups'))
            ->addItem(action('PermissionGroupsController@show', $params['permission_groups']->slug), $params['permission_groups']->name);
        $this->menu->handler('permission-groups.panel-buttons.edit')
            ->addClass('pull-right')
            ->addItemIf($this->check('index'), action('PermissionGroupsController@index'), trans('permission-groups.list_all'), 'btn btn-primary');
        $this->menu->handler('permission-groups.record-buttons.edit')
            ->addItemIf($this->check('show'), action('PermissionGroupsController@show', $params['permission_groups']->slug), trans('permission-groups.show'), 'btn btn-default');
    }

    public function revisions($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('PermissionGroupsController@index'), trans('permission-groups.permission_groups'))
            ->addItem(action('PermissionGroupsController@show', $params['permission_groups']->slug), $params['permission_groups']->name)
            ->addItem(action('PermissionGroupsController@revisions', $params['permission_groups']->slug), trans('permission-groups.revisions'));
        $this->menu->handler('permission-groups.panel-buttons.revisions')
            ->addClass('pull-right')
            ->addItemIf($this->check('index'), action('PermissionGroupsController@index'), trans('permission-groups.list_all'), 'btn btn-primary')
            ->addItemIf($this->check('show'), action('PermissionGroupsController@show', $params['permission_groups']->slug), trans('permission-groups.show'), 'btn btn-default');
    }

    public function __construct()
    {
        parent::__construct();
        $this->menu->handler('admin')
            ->addItemIf($this->check('index'), action('PermissionGroupsController@index'), trans('permission-groups.permission_groups'));
    }

}