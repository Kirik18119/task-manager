<?php

namespace App\Core;

use App\Model\User;
use App\Core\ORM\Model;

class Auth
{
    private static string $userModelClassName = User::class;

    private static ?Model $authorizedUser;

    public static function user(): ?Model
    {
        $userId = SessionManager::get('user_id');

        return ($userId) ? (static::$authorizedUser ?? static::$authorizedUser = User::find($userId)) : null;
    }
}