<?php

/**
 * This file is only loaded under the local environment
 * useful for debugging or testing out new features
 * before moving it to the production environment
 */

Route::get('/reset', function(){
    Artisan::call('db:seed');
    File::cleanDirectory(public_path() . '/uploads');
    file_put_contents(public_path() . '/uploads/.gitignore', "*\n!.gitignore\n!index.html");
    touch(public_path() . '/uploads/index.html');
    return Redirect::action('AuthController@login');
});