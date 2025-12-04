<?php

namespace App\Guard;

use App\Core\Auth;
use Exception;

class Admin
{
    /**
     * @throws Exception
     */
    public function handle(): void
    {
        (new Authorized())->handle();
        $user = Auth::user();
        if (!$user->isAdmin())
        {
            throw new Exception('Forbidden action');
        }
    }
}