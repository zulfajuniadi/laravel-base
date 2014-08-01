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
Route::get('/', ['before' => 'auth', function()
{
  return View::make('home', ['controller' => 'Home']);
}]);

Route::resource('users', 'UserController');
Route::resource('organizationunits', 'OrganizationUnitsController');

Route::group(['before' => ['auth','admin']], function(){
  Route::resource('roles', 'RolesController');
  Route::resource('permissions', 'PermissionsController');
});

// Confide routes
Route::get( 'auth/register',               'UserController@create');
Route::post('auth',                        'UserController@store');
Route::get( 'auth/login',                  'UserController@login');
Route::post('auth/login',                  'UserController@do_login');
Route::get( 'auth/confirm/{code}',         'UserController@confirm');
Route::get( 'auth/forgot_password',        'UserController@forgot_password');
Route::post('auth/forgot_password',        'UserController@do_forgot_password');
Route::get( 'auth/reset_password/{token}', 'UserController@reset_password');
Route::post('auth/reset_password',         'UserController@do_reset_password');
Route::get( 'auth/logout',                 'UserController@logout');
