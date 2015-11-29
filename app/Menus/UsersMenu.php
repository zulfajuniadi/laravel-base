<?php

namespace App\Menus;

use App\Libraries\Menu\BaseMenu;
use App\Http\Controllers\UsersController;

class UsersMenu extends BaseMenu
{

    protected $controller = UsersController::class;

    public function index($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('UsersController@index'), trans('users.users'));
        $this->menu->handler('users.panel-buttons')
            ->addClass('pull-right')
            ->addItemIf($this->check('create'), action('UsersController@create'), trans('users.create'), 'btn btn-primary');
    }

    public function create($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('UsersController@index'), trans('users.users'))
            ->addItem(action('UsersController@create'), trans('users.create'));
        $this->menu->handler('users.panel-buttons.create')
            ->addClass('pull-right')
            ->addItemIf($this->check('index'), action('UsersController@index'), trans('users.list_all'), 'btn btn-primary');
    }

    public function show($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('UsersController@index'), trans('users.users'))
            ->addItem(action('UsersController@show', $params['users']->slug), $params['users']->name);
        $this->menu->handler('users.panel-buttons.show')
            ->addClass('pull-right')
            ->addItemIf($this->check('index'), action('UsersController@index'), trans('users.list_all'), 'btn btn-primary')
            ->addItemIf($this->check('create'), action('UsersController@create'), trans('users.create'), 'btn btn-default');
        $this->menu->handler('users.record-buttons.show')
            ->addItemIf($this->check('edit', $params), action('UsersController@edit', $params['users']->slug), trans('users.edit'), 'btn btn-primary')
            ->addItemIf($this->check('assume', $params), action('UsersController@assume', $params['users']->slug), trans('users.assume'), 'btn btn-default')
            ->addItemIf($this->check('activate', $params) && !$params['users']->is_active, action('UsersController@activate', $params['users']->slug), trans('users.activate'), 'btn btn-default')
            ->addItemIf($this->check('deactivate', $params) && $params['users']->is_active, action('UsersController@deactivate', $params['users']->slug), trans('users.deactivate'), 'btn btn-default')
            ->addItemIf($this->check('revisions', $params), action('UsersController@revisions', $params['users']->slug), trans('users.revisions'), 'btn btn-default')
            ->addItemIf($this->check('duplicate', $params), action('UsersController@duplicate', $params['users']->slug),  trans('users.duplicate'), 'btn btn-default')
            ->addItemIf($this->check('index', $params, \App\Http\Controllers\UserBlacklistsController::class), action('UserBlacklistsController@index', $params['users']->slug),  trans('user-blacklists.user_blacklists'), 'btn btn-default')
            ->addItemIf($this->check('delete', $params), action('UsersController@delete', $params['users']->slug), trans('users.delete'), 'btn btn-danger confirm-action');
    }

    public function edit($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('UsersController@index'), trans('users.users'))
            ->addItem(action('UsersController@show', $params['users']->slug), $params['users']->name);
        $this->menu->handler('users.panel-buttons.edit')
            ->addClass('pull-right')
            ->addItemIf($this->check('index'), action('UsersController@index'), trans('users.list_all'), 'btn btn-primary');
        $this->menu->handler('users.record-buttons.edit')
            ->addItemIf($this->check('show'), action('UsersController@show', $params['users']->slug), trans('users.show'), 'btn btn-default');
    }

    public function revisions($params)
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('UsersController@index'), trans('users.users'))
            ->addItem(action('UsersController@show', $params['users']->slug), $params['users']->name)
            ->addItem(action('UsersController@revisions', $params['users']->slug), trans('users.revisions'));
        $this->menu->handler('users.panel-buttons.revisions')
            ->addClass('pull-right')
            ->addItemIf($this->check('index'), action('UsersController@index'), trans('users.list_all'), 'btn btn-primary')
            ->addItemIf($this->check('show'), action('UsersController@show', $params['users']->slug), trans('users.show'), 'btn btn-default');
    }

    public function profile()
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('UsersController@profile'), trans('users.profile'));
        $this->menu->handler('users.record-buttons')
            ->addItemIf($this->check('editProfile'), action('UsersController@editProfile'), trans('users.edit_profile'), 'btn btn-primary')
            ->addItemIf($this->check('changePassword'), action('UsersController@changePassword'), trans('users.change_password'), 'btn btn-default')
        ;
    }

    public function changePassword()
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('UsersController@profile'), trans('users.profile'))
            ->addItem(action('UsersController@changePassword'), trans('users.change_password'))
            ;
        $this->menu->handler('users.panel-buttons')
            ->addClass('pull-right')
            ->addItemIf($this->check('profile'), action('UsersController@profile'), trans('users.profile'), 'btn btn-default')
        ;
    }

    public function editProfile()
    {
        $this->menu->handler('breadcrumbs')
            ->addItem(action('UsersController@profile'), trans('users.profile'))
            ->addItem(action('UsersController@editProfile'), trans('users.edit_profile'))
            ;
        $this->menu->handler('users.panel-buttons')
            ->addClass('pull-right')
            ->addItemIf($this->check('profile'), action('UsersController@profile'), trans('users.profile'), 'btn btn-default')
        ;
    }

    public function __construct()
    {
        parent::__construct();
        $this->menu->handler('admin')
            ->addItemIf($this->check('index'), action('UsersController@index'), trans('users.users'));
    }

}