<?php

namespace App\Menus;

use App\Libraries\Menu\BaseMenu;
use App\Http\Controllers\AuthLogsController;

class AuthLogsMenu extends BaseMenu
{

    protected $controller = AuthLogsController::class;

    public function index($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('AuthLogsController@index'), trans('auth-logs.auth_logs'));
        $this->menu->handler('auth-logs.panel-buttons')
            ->addClass('pull-right')
            ->addItemIf($this->check('create'), action('AuthLogsController@create'), trans('auth-logs.create'), 'btn btn-primary');
    }

    public function create($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('AuthLogsController@index'), trans('auth-logs.auth_logs'))
            ->addItem(action('AuthLogsController@create'), trans('auth-logs.create'));
        $this->menu->handler('auth-logs.panel-buttons.create')
            ->addClass('pull-right')
            ->addItemIf($this->check('index'), action('AuthLogsController@index'), trans('auth-logs.list_all'), 'btn btn-primary');
    }

    public function show($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('AuthLogsController@index'), trans('auth-logs.auth_logs'))
            ->addItem(action('AuthLogsController@show', $params['auth_logs']->slug), $params['auth_logs']->name);
        $this->menu->handler('auth-logs.panel-buttons.show')
            ->addClass('pull-right')
            ->addItemIf($this->check('index'), action('AuthLogsController@index'), trans('auth-logs.list_all'), 'btn btn-primary')
            ->addItemIf($this->check('create'), action('AuthLogsController@create'), trans('auth-logs.create'), 'btn btn-default');
        $this->menu->handler('auth-logs.record-buttons.show')
            ->addItemIf($this->check('edit', $params), action('AuthLogsController@edit', $params['auth_logs']->slug), trans('auth-logs.edit'), 'btn btn-primary')
            ->addItemIf($this->check('revisions', $params), action('AuthLogsController@revisions', $params['auth_logs']->slug), trans('auth-logs.revisions'), 'btn btn-default')
            ->addItemIf($this->check('duplicate', $params), action('AuthLogsController@duplicate', $params['auth_logs']->slug),  trans('auth-logs.duplicate'), 'btn btn-default')
            ->addItemIf($this->check('delete', $params), action('AuthLogsController@delete', $params['auth_logs']->slug), trans('auth-logs.delete'), 'btn btn-danger confirm-action');
    }

    public function edit($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('AuthLogsController@index'), trans('auth-logs.auth_logs'))
            ->addItem(action('AuthLogsController@show', $params['auth_logs']->slug), $params['auth_logs']->name);
        $this->menu->handler('auth-logs.panel-buttons.edit')
            ->addClass('pull-right')
            ->addItemIf($this->check('index'), action('AuthLogsController@index'), trans('auth-logs.list_all'), 'btn btn-primary');
        $this->menu->handler('auth-logs.record-buttons.edit')
            ->addItemIf($this->check('show'), action('AuthLogsController@show', $params['auth_logs']->slug), trans('auth-logs.show'), 'btn btn-default');
    }

    public function revisions($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('AuthLogsController@index'), trans('auth-logs.auth_logs'))
            ->addItem(action('AuthLogsController@show', $params['auth_logs']->slug), $params['auth_logs']->name)
            ->addItem(action('AuthLogsController@revisions', $params['auth_logs']->slug), trans('auth-logs.revisions'));
        $this->menu->handler('auth-logs.panel-buttons.revisions')
            ->addClass('pull-right')
            ->addItemIf($this->check('index'), action('AuthLogsController@index'), trans('auth-logs.list_all'), 'btn btn-primary')
            ->addItemIf($this->check('show'), action('AuthLogsController@show', $params['auth_logs']->slug), trans('auth-logs.show'), 'btn btn-default');
    }

    public function __construct()
    {
        parent::__construct();
        $this->menu->handler('admin')
            ->addItemIf($this->check('index'), action('AuthLogsController@index'), trans('auth-logs.auth_logs'));
    }

}