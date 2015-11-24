<?php 

namespace App\Repositories;

use App\AuthLog;
use App\User;
use App\Exceptions\RepositoryException;

class AuthLogsRepository extends BaseRepository {
    public static function log(User $user, $action)
    {
        static::create(new AuthLog, [
            'user_id' => $user->id,
            'ip_address' => app('request')->ip(),
            'action' => $action
        ]);
    }
}