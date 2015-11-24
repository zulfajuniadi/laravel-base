<?php

namespace App\Menus;

use App\Libraries\Menu\BaseMenu;
use App\Http\Controllers\UserBlacklistsController;
use App\Http\Controllers\UsersController;

class UserBlacklistsMenu extends BaseMenu
{

    protected $controller = UserBlacklistsController::class;

    public function index($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('UsersController@index'), trans('users.users'))
            ->addItem(action('UsersController@show', $params['users']->slug), $params['users']->name)
            ->addItem(action('UserBlacklistsController@index', $params['users']->slug), trans('user-blacklists.user_blacklists'));
        $this->menu->handler('user-blacklists.panel-buttons')
            ->addClass('pull-right')
            ->addItemIf($this->check('create', $params), action('UserBlacklistsController@create', $params['users']->slug), trans('user-blacklists.create'), 'btn btn-primary')
            ->addItemIf($this->check('show', $params, UsersController::class), action('UsersController@show', $params['users']->slug), trans('users.show'), 'btn btn-default');
    }

    public function create($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('UsersController@index'), trans('users.users'))
            ->addItem(action('UsersController@show', $params['users']->slug), $params['users']->name)
            ->addItem(action('UserBlacklistsController@index', $params['users']->slug), trans('user-blacklists.user_blacklists'))
            ->addItem(action('UserBlacklistsController@create', $params['users']->slug), trans('user-blacklists.create'));
        $this->menu->handler('user-blacklists.panel-buttons.create')
            ->addClass('pull-right')
            ->addItemIf($this->check('index'), action('UserBlacklistsController@index', $params['users']->name), trans('user-blacklists.list_all'), 'btn btn-primary');
    }

    public function show($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('UsersController@index'), trans('users.users'))
            ->addItem(action('UsersController@show', $params['users']->slug), $params['users']->name)
            ->addItem(action('UserBlacklistsController@index', $params['users']->slug), trans('user-blacklists.user_blacklists'))
            ->addItem(action('UserBlacklistsController@show', $params['user_blacklists']->slug), $params['user_blacklists']->name);
        $this->menu->handler('user-blacklists.panel-buttons.show')
            ->addClass('pull-right')
            ->addItemIf($this->check('index'), action('UserBlacklistsController@index', $params['users']->slug), trans('user-blacklists.list_all'), 'btn btn-primary')
            ->addItemIf($this->check('create'), action('UserBlacklistsController@create', $params['users']->slug), trans('user-blacklists.create'), 'btn btn-default');
        $this->menu->handler('user-blacklists.record-buttons.show')
            ->addItemIf($this->check('edit', $params), action('UserBlacklistsController@edit', [$params['users']->slug, $params['user_blacklists']->slug]), trans('user-blacklists.edit'), 'btn btn-primary')
            ->addItemIf($this->check('revisions', $params), action('UserBlacklistsController@revisions', [$params['users']->slug, $params['user_blacklists']->slug]), trans('user-blacklists.revisions'), 'btn btn-default')
            ->addItemIf($this->check('duplicate', $params), action('UserBlacklistsController@duplicate', [$params['users']->slug, $params['user_blacklists']->slug]),  trans('user-blacklists.duplicate'), 'btn btn-default')
            ->addItemIf($this->check('delete', $params), action('UserBlacklistsController@delete', [$params['users']->slug, $params['user_blacklists']->slug]), trans('user-blacklists.delete'), 'btn btn-danger confirm-action');
    }

    public function edit($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('UsersController@index'), trans('users.users'))
            ->addItem(action('UsersController@show', $params['users']->slug), $params['users']->name)
            ->addItem(action('UserBlacklistsController@index', $params['users']->slug), trans('user-blacklists.user_blacklists'))
            ->addItem(action('UserBlacklistsController@show', $params['user_blacklists']->slug), $params['user_blacklists']->name);
        $this->menu->handler('user-blacklists.panel-buttons.edit')
            ->addClass('pull-right')
            ->addItemIf($this->check('index'), action('UserBlacklistsController@index', $params['users']->name), trans('user-blacklists.list_all'), 'btn btn-primary');
        $this->menu->handler('user-blacklists.record-buttons.edit')
            ->addItemIf($this->check('show'), action('UserBlacklistsController@show', [$params['users']->name, $params['user_blacklists']->slug]), trans('user-blacklists.show'), 'btn btn-default');
    }

    public function revisions($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('UsersController@index'), trans('users.users'))
            ->addItem(action('UsersController@show', $params['users']->slug), $params['users']->name)
            ->addItem(action('UserBlacklistsController@index', $params['users']->slug), trans('user-blacklists.user_blacklists'))
            ->addItem(action('UserBlacklistsController@show', [$params['users']->slug, $params['user_blacklists']->slug]), $params['user_blacklists']->name)
            ->addItem(action('UserBlacklistsController@revisions', [$params['users']->slug, $params['user_blacklists']->slug]), trans('user-blacklists.revisions'));
        $this->menu->handler('user-blacklists.panel-buttons.revisions')
            ->addClass('pull-right')
            ->addItemIf($this->check('index'), action('UserBlacklistsController@index', $params['users']->slug), trans('user-blacklists.list_all'), 'btn btn-primary')
            ->addItemIf($this->check('show'), action('UserBlacklistsController@show', [$params['users']->slug, $params['user_blacklists']->slug]), trans('user-blacklists.show'), 'btn btn-default');
    }

    public function __construct()
    {
        parent::__construct();
    }

}