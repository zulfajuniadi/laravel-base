<?php 

namespace App\Repositories;

use App\User;
use App\Exceptions\RepositoryException;

class UsersRepository extends BaseRepository {
    public static function assume(User $user)
    {
        app('session')->put('original_user', app('auth')->user()->id);
        app('auth')->login($user);
    }
    
    public static function resume()
    {
        $user = User::find(app('session')->pull('original_user'));
        if($user) {
            app('auth')->login($user);
            return $user;
        }
    }

    public static function setActivation(User $user, $activation = false)
    {
        $user->is_active = $activation;
        $user->save();
    }

    public static function changePassword(User $user, $newPassword)
    {
        $user->update([
            'password' => app('hash')->make($newPassword)
        ]);
    }

    public static function updateProfile(User $user, $data)
    {
        $user->update($data);
    }
}