<?php

namespace Core\ORM\Trait;

use Core\Database;
use Core\ORM\Model;

trait HasWrites
{
    public static function create(array $values = []): Model
    {
        $params = [];
        foreach ($values as $field => $value)
        {
            if (array_key_exists($field, static::$casts)) {
                $value = static::castReverse($field, $value);
            }
            $params[$field] = $value;
        }

        $connection = Database::getConnection();
        $query = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            static::$table,
            implode(',', array_keys($params)),
            implode(',', array_map(fn ($field) => ":$field", array_keys($params)))
        );

        $stmt = $connection->prepare($query);

        foreach ($params as $field => $value)
        {
            $stmt->bindParam(":$field", $value);
        }

        $stmt->execute();

        return static::find($connection->lastInsertId());
    }

    public function update(array $values = []): void
    {
        $params = [];
        foreach ($values as $field => $value)
        {
            if (array_key_exists($field, static::$casts)) {
                $value = static::castReverse($field, $value);
            }
            $params[$field] = $value;
        }

        $connection = Database::getConnection();
        $query = sprintf(
            "UPDATE %s SET %s WHERE %s = :id",
            static::$table,
            implode(',', array_map(fn ($field) => "$field=:$field", array_keys($params))),
            static::$primaryKey
        );

        $stmt = $connection->prepare($query);

        foreach ($params as $field => $value)
        {
            $stmt->bindParam(":$field", $value);
            $this->{$field} = $value;
        }

        $stmt->bindParam(":id", $this->{static::$primaryKey});
        $stmt->execute($params);
    }

    public function delete(): void
    {
        $connection = Database::getConnection();

        $query = sprintf("DELETE FROM %s WHERE %s = :id", static::$table, static::$primaryKey);
        $stmt = $connection->prepare($query);
        $stmt->execute([':id' => $this->{static::$primaryKey}]);
    }
}