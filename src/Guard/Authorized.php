<?php

namespace App\Guard;

use App\Core\SessionManager;
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
            throw new Exception('Unauthorized action');
        }

        $user = User::find($userId);
        if (!$user)
        {
            throw new Exception('Unauthorized action');
        }
    }
}