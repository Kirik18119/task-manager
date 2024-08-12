<?php

namespace App\Сore;

class DatabaseConnection
{
    private static ?\PDO $connection ;

    public static function getConnection()
    {
        if (!isset(self::$connection))
        {
            self::$connection = new \PDO("mysql:host=localhost;dbname=task_manager", "root", "");
        }

        return self::$connection;
    }
}