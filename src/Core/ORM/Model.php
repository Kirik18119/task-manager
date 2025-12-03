<?php

namespace App\Core\ORM;

use App\Core\Database;
use PDO;

abstract class Model
{
    protected static string $table;

    protected static string $primaryKey = 'id';

    /**
     * available casts
     *  property_name => boolean
     *  property_name => datetime
     *  property_name => SomeEnum::class
     */
    protected static array $casts = [];

    private static function cast(string $field, mixed $value): mixed
    {
        if (enum_exists(static::$casts[$field]))
        {
            $value = FieldCast::enumCast(static::$casts[$field], $value);
        }
        else
        {
            $castName = static::$casts[$field] . 'Cast';
            $value = FieldCast::{$castName}($value);
        }

        return $value;
    }

    private static function castReverse(string $field, mixed $value): mixed
    {
        if (enum_exists(static::$casts[$field]))
        {
            $value = FieldCast::enumCastReverse($value);
        }
        else
        {
            $castName = static::$casts[$field] . 'CastReverse';
            $value = FieldCast::{$castName}($value);
        }

        return $value;
    }

    public static function find(int $id): ?Model
    {
        $connection = Database::getConnection();
        $query = sprintf("SELECT * FROM %s WHERE %s = :id", self::$table, self::$primaryKey);
        $stmt = $connection->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        $rawData = $stmt->fetch();
        if (!$rawData || count($rawData) == 0) {
            return null;
        }

        $model = new static();
        foreach ($rawData as $field => $value) {
            if (array_key_exists($field, static::$casts)) {
                $value = static::cast($field, $value);
            }
            $model->$field = $value;
        }

        return $model;
    }

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