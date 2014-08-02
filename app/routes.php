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

  Route::group(['before' => ['can:User:list']], function(){
    Route::resource('users', 'UsersController');
  });

  Route::group(['before' => ['can:OrganizationUnit:list']], function(){
    Route::resource('organizationunits', 'OrganizationUnitsController');
  });

  Route::group(['before' => ['can:Role:list']], function(){
    Route::resource('roles', 'RolesController');
  });

  Route::group(['before' => ['can:Permission:list']], function(){
    Route::resource('permissions', 'PermissionsController');
  });
  
  Route::get('profile', 'UsersController@profile');
  Route::get('users/{user_id}/set_password', 'UsersController@getSetPassword');
  Route::put('users/{user_id}/set_password', 'UsersController@putSetPassword');
  Route::put('users/{user_id}/set_activation', 'UsersController@putSetConfirmation');
  Route::get('profile/change_password', 'UsersController@getChangePassword');
  Route::put('profile/change_password', 'UsersController@putChangePassword');
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
