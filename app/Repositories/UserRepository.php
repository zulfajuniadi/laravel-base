<?php 

namespace App\Repositories;

use App\User;
use App\Exceptions\RepositoryException;

class UserRepository extends BaseRepository
{

    public static function setActive(User $user)
    {
        $user->is_active = true;
        if(!$user->save())
            throw new RepositoryException('Set User State Active');
        return $user;
    }

    public static function setInactive(User $user)
    {
        $user->is_active = false;
        if(!$user->save())
            throw new RepositoryException('Set User State Inactive');
        return $user;
    }

    public function changePassword(User $user, $new_password)
    {
        $user->password = app()->make('hash')->make($new_password);
        if(!$user->save())
            throw new RepositoryException('Set User Password');
        return $user;
    }
}