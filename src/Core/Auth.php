<?php

namespace Core;

use App\Model\User;
use Core\ORM\Model;

class Auth
{
    private static string $userModelClassName = User::class;

    private static ?Model $authorizedUser;

    public static function user(): ?Model
    {
        $userId = SessionManager::get('user_id');

        return ($userId) ? (static::$authorizedUser ?? static::$authorizedUser = static::$userModelClassName::find($userId)) : null;
    }
}