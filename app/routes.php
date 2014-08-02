<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(['before' => 'auth'], function(){
  Route::get('/', function()
  {
    return View::make('home', ['controller' => 'Home']);
  });

  Route::group(['before' => ['canList:User']], function(){
    Route::resource('users', 'UsersController');
  });

  Route::group(['before' => ['canList:OrganizationUnit']], function(){
    Route::resource('organizationunits', 'OrganizationUnitsController');
  });

  Route::group(['before' => ['canList:Role']], function(){
    Route::resource('roles', 'RolesController');
  });

  Route::group(['before' => ['canList:Permission']], function(){
    Route::resource('permissions', 'PermissionsController');
  });
  
  Route::get( 'auth/logout', 'AuthController@logout');
});

// Confide routes
Route::get( 'auth/register',               'AuthController@create');
Route::post('auth',                        'AuthController@store');
Route::get( 'auth/login',                  'AuthController@login');
Route::post('auth/login',                  'AuthController@do_login');
Route::get( 'auth/confirm/{code}',         'AuthController@confirm');
Route::get( 'auth/forgot_password',        'AuthController@forgot_password');
Route::post('auth/forgot_password',        'AuthController@do_forgot_password');
Route::get( 'auth/reset_password/{token}', 'AuthController@reset_password');
Route::post('auth/reset_password',         'AuthController@do_reset_password');
