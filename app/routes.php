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

Route::group(['before' => 'auth'], function () {
    Route::get('/', 'HomeController@index');

    Route::resource('users', 'UsersController');
    Route::resource('roles', 'RolesController');
    Route::resource('permissions', 'PermissionsController');
    
    Route::get('profile', 'UsersController@profile');
    Route::get('users/{user_id}/set_password', 'UsersController@getSetPassword');
    Route::put('users/{user_id}/set_password', 'UsersController@putSetPassword');
    Route::get('profile/change_password', 'UsersController@getChangePassword');
    Route::put('profile/change_password', 'UsersController@putChangePassword');
    Route::put('users/{user_id}/set_confirmation', 'UsersController@putSetConfirmation');
    Route::get('auth/logout', 'AuthController@logout');

    Route::resource('uploader', 'UploadsController');
    Route::get('uploader/{id}/remove', 'UploadsController@remove');
    Route::controller('reports', 'ReportController');
});

// Confide routes
Route::get('auth/register', 'AuthController@create');
Route::post('auth', 'AuthController@store');
Route::get('auth/login', 'AuthController@login');
Route::post('auth/login', 'AuthController@doLogin');
Route::get('auth/confirm/{code}', 'AuthController@confirm');
Route::get('auth/forgot_password', 'AuthController@forgotPassword');
Route::post('auth/forgot_password', 'AuthController@doForgotPassword');
Route::get('auth/reset/{token}', 'AuthController@resetPassword');
Route::post('auth/reset', 'AuthController@doResetPassword');
