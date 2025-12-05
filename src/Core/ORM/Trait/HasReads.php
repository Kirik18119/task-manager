<?php

namespace Core\ORM\Trait;

use Core\Collection\ICollection;
use Core\Database;
use Core\ORM\Model;
use PDO;

trait HasReads
{
    public static function find(int $id): ?Model
    {
        $connection = Database::getConnection();
        $query = sprintf("SELECT * FROM %s WHERE %s = :id", static::$table, static::$primaryKey);
        $stmt = $connection->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        $rawData = $stmt->fetch();
        if (!$rawData || count($rawData) == 0) {
            return null;
        }

        return static::mapRawToModel($rawData);
    }

    public static function findAll(): ICollection
    {
        $connection = Database::getConnection();
        $query = sprintf("SELECT * FROM %s", static::$table);
        $stmt = $connection->prepare($query);
        $stmt->execute();

        return static::mapRawToCollection($stmt->fetchAll());
    }

    public static function findBy(array $options): ICollection
    {
        $connection = Database::getConnection();
        $query = sprintf(
            "SELECT * FROM %s WHERE %s",
            static::$table,
            implode(' AND', array_map(fn ($field) => "$field=:$field", array_keys($options))));

        $stmt = $connection->prepare($query);
        $stmt->execute(array_combine(
            array_map(fn ($key) => ":$key", array_keys($options)),
            array_values($options)
        ));

        return static::mapRawToCollection($stmt->fetchAll());
    }
}