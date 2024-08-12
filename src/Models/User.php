<?php

namespace App\Models;

use App\Сore\BaseModel;

class User extends BaseModel
{
    protected static string $table = 'users';
    protected static string $primaryKey = 'id';

    public int $id;

    public string $first_name;

    public string $last_name;

    public string $email;

    public string $password;
}