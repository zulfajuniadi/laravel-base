<?php

class HomeController extends BaseController
{

    public function index()
    {
        return View::make('home');
    }


    public function __construct()
    {
        parent::__construct();
        View::share('controller', 'Home');
    }

}