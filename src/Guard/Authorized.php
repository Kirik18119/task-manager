<?php

namespace App\Guard;

use Core\Utils\SessionManager;
use App\Model\User;
use Exception;

class Authorized
{
    /**
     * @throws Exception
     */
    public function handle(): void
    {
        $userId = SessionManager::get('user_id');
        if (!$userId)
        {
            throw new Exception('Unauthorized action', 401);
        }

        $user = User::find($userId);
        if (!$user)
        {
            throw new Exception('Unauthorized action', 401);
        }
    }
}