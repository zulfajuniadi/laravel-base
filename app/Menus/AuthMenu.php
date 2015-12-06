<?php

namespace App\Menus;

use App\Libraries\Menu\BaseMenu;
use App\Http\Controllers\AuthLogsController;

class AuthMenu extends BaseMenu
{

    public function make()
    {
        $menu = app('menu')
            ->handler('auth')
            ->addClass('navbar-right')
            ->addItemIf(auth()->guest(), action('Auth\AuthController@getLogin'), trans('auth.login'))
            ->addItemIf(auth()->guest(), action('Auth\AuthController@getRegister'), trans('auth.register'))
            ->addItemIf(app('session')->has('original_user'), action('UsersController@resume'), trans('users.resume'))
            ->addItemIfNot(auth()->guest(), action('UsersController@profile'), trans('users.profile'))
            ->addItemIfNot(auth()->guest(), action('Auth\AuthController@getLogout'), trans('auth.logout'))
            ;
        if(!auth()->guest()) {
            $menu->setTitle('<img class="navbar-avatar" src="' . auth()->user()->getAvatarUrl() . '">' . auth()->user()->name);
        } else {
            $menu->setType('navbar-inline');
        }
    }

    public function __construct()
    {
        parent::__construct();
    }

}