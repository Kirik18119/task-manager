<?php

namespace Core\ORM;

use Core\Collection\ArrayCollection;
use Core\Database;
use Core\ORM\Relation\BelongTo;
use Core\ORM\Relation\HasMany;
use Core\ORM\Relation\HasOne;
use Exception;

class QueryBuilder
{
    private string $rawSql;

    public function __construct(
        /** @var class-string<Model> $modelClassName */
        private readonly string $modelClassName,
        private readonly array $selectedColumns,
        private readonly string $tableName,
        private readonly string $primaryKey
    )
    {
        $this->rawSql = sprintf("SELECT %s FROM %s ", implode(',', $this->selectedColumns), $this->tableName);
    }

    /**
     * @throws Exception
     */
    public function with(array $relations)
    {
        $modelTempObject = new $this->modelClassName;
        foreach ($relations as $relation)
        {
            if (!method_exists($this->modelClassName, $relation))
            {
                throw new Exception(sprintf('Relation %s is not defined for %s', $relation, $this->modelClassName));
            }

            $relationInstance = $modelTempObject->{$relation}();
            if ($relationInstance instanceof BelongTo)
            {
                $this->rawSql .= sprintf("LEFT JOIN %s ON %s.%s = %s.%s ",
                    $relationInstance->parentClassName::$table,
                    $this->modelClassName::$table,
                    $relationInstance->foreignKeyName,
                    $relationInstance->parentClassName::$table,
                    $relationInstance->parentClassName::$primaryKey
                );
            }
            else if ($relationInstance instanceof HasOne || $relationInstance instanceof HasMany)
            {
                $this->rawSql .= sprintf("LEFT JOIN %s ON %s.%s = %s.%s ",
                    $relationInstance->childClassName::$table,
                    $this->modelClassName::$table,
                    $this->modelClassName::$primaryKey,
                    $relationInstance->childClassName::$table,
                    $relationInstance->localKeyName
                );
            }
            else
            {
                throw new Exception("Undefined type of relation for %s relation", $relation);
            }
            unset($relationInstance);
        }
        unset($modelTempObject);
    }

    /**
     * @throws Exception
     */
    public function get(): ArrayCollection
    {
        $connection = Database::getConnection();
        $statement = $connection->prepare($this->rawSql);
        $statement->execute();

        return $this->modelClassName::mapRawToCollection($statement->fetchAll());
    }
}