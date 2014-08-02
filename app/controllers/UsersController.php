<?php

class UsersController extends \BaseController
{
  public function index()
  {
    return View::make('users.index');
  }

  public function __construct()
  {
    parent::__construct();
    View::share('controller', 'UsersController');
  }
}