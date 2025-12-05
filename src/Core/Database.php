<?php

namespace Core;

use PDO;

class Database
{
    private static ?PDO $connection;

    private const string HOST = 'localhost';

    private const string DB_NAME = 'task_manager';

    private const string DB_USERNAME = 'root';

    private const string DB_PASSWORD = 'password';

    private const string DSN = "mysql:host=localhost;dbname=task_manager;charset=utf8mb4";

    public static function getConnection(): ?PDO
    {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        return self::$connection ?? self::$connection = new PDO(self::DSN, self::DB_USERNAME, self::DB_PASSWORD, $options);
    }
}