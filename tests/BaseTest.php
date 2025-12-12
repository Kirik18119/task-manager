<?php

namespace Tests;

use Core\Application;
use Core\Database;
use PDO;
use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
    protected Application $app;

    protected function setUp(): void
    {
        $this->app = new Application('test');
        $pdo = Database::getConnection();

        $schemaSql = file_get_contents(dirname(__DIR__) . '/sqlite-script.sql');
        $pdo->exec($schemaSql);
    }

    protected function assertDatabaseNotEmpty(string $table): void
    {
        $connection = Database::getConnection();
        $query = sprintf("SELECT * FROM %s", $table);
        $stmt = $connection->prepare($query);
        $stmt->execute();
        $this->assertGreaterThan(0, count($stmt->fetchAll()));
    }

    protected function assertDatabaseHas(string $table, array $fields): void
    {
        $connection = Database::getConnection();
        $whereClause = implode(' AND ', array_map(function ($value, $key) {
            return "`{$key}` = :{$value}";
        }, $fields, array_keys($fields)));
        $query = sprintf("SELECT * FROM %s WHERE %s", $table, $whereClause);
        $stmt = $connection->prepare($query);
        $stmt->execute();

        $this->assertGreaterThanOrEqual(0, count($stmt->fetchAll()));
    }
}