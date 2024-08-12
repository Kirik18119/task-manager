<?php

namespace App\Сore;

class BaseModel
{
    protected static string $table;

    protected static string $primaryKey;

    public static function findAll()
    {
        $connection = DatabaseConnection::getConnection();
        $tableName = static::$table;
        $query = "SELECT * FROM $tableName";
        $stmt = $connection->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $collection = [];

        foreach ($result as $row)
        {
            $object = new static();
            foreach ($row as $field => $value)
            {
                $object->{$field} = $value;
            }

            $collection []= $object;
        }

        return $collection;
    }

    public static function find(mixed $id)
    {
        $primaryKey = static::$primaryKey;
        $connection = DatabaseConnection::getConnection();
        $tableName = static::$table;
        $query = "SELECT * FROM $tableName WHERE $primaryKey = :id";
        $stmt = $connection->prepare($query);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return ($result == null) ? 'ERROR 404' : $result;

    }

    public function save()
    {
        $connection = DatabaseConnection::getConnection();
        $properties = get_class_vars($this::class);
        unset($properties['table']);
        unset($properties[$properties['primaryKey']]);
        unset($properties['primaryKey']);

        $properties = array_keys($properties);
        $tableName = static::$table;
        $fields = implode(',',$properties);
        $placeholders = implode(",", array_map(fn ($property) => ":$property", $properties));

        $params = [];
        foreach($properties as $property)
        {
            $params[$property] = $this->{$property};
        }
        $query = "INSERT INTO $tableName ($fields) VALUES ($placeholders) ";
        $stmt = $connection->prepare($query);
        $stmt->execute($params);
    }

    public function delete(mixed $id)
    {
        $primaryKey = static::$primaryKey;
        $connection = DatabaseConnection::getConnection();
        $tableName = static::$table;
        $query = "DELETE FROM $tableName WHERE $primaryKey = :id";
        $stmt = $connection->prepare($query);
        $stmt->execute(['id' => $id]);
        return 'DELETED';
    }
}