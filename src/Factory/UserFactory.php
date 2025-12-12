<?php

namespace App\Factory;

use Core\ORM\AbstractFactory;
use Core\Utils\Hash;
use App\Enum\UserCategory;
use App\Model\User;
use Random\RandomException;

class UserFactory extends AbstractFactory
{
    protected static string $model = User::class;

    /**
     * @throws RandomException
     */
    public static function definition(): array
    {
        return [
            'first_name' => faker()->randomString(20)->get(),
            'last_name' => faker()->randomString(20)->get(),
            'email' => faker()->email(20)->get(),
            'password' => Hash::make('12345678'),
            'is_admin' => false,
            'category' => faker()->randomEnum(UserCategory::class)->get(),
        ];
    }
}