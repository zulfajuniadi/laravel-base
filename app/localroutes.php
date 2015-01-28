<?php

/**
 * This file is only loaded under the local environment
 * useful for debugging or testing out new features
 * before moving it to the production environment
 */

View::share('localroute', true);

Route::get('/reset', function(){
    Artisan::call('db:seed');
    File::cleanDirectory(public_path() . '/uploads');
    file_put_contents(public_path() . '/uploads/.gitignore', "*\n!.gitignore\n!index.html");
    touch(public_path() . '/uploads/index.html');
    return Redirect::action('AuthController@login');
});


Route::get('/report-builder', function(){

    $roles = Auth::user()->roles();
    return json_encode($roles->getQuery());

});

Route::resource('report-builder', 'ReportsController');
Route::resource('report-categories', 'ReportCategoriesController');
Route::resource('report-builder.fields', 'ReportFieldsController');
Route::resource('report-builder.eagers', 'ReportEagersController');
Route::resource('report-builder.groupings', 'ReportGroupingsController');
Route::resource('report-builder.columns', 'ReportColumnsController');
