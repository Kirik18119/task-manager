<?php

namespace Core\ORM;

use Core\Collection\ArrayCollection;
use Core\Database;

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
        $this->rawSql = sprintf("SELECT %s FROM %s", implode(',', $this->selectedColumns), $this->tableName);
    }

    public function with(array $relations)
    {

    }

    /**
     * @throws \Exception
     */
    public function get(): ArrayCollection
    {
        $connection = Database::getConnection();
        $statement = $connection->prepare($this->rawSql);
        $statement->execute();

        return $this->modelClassName::mapRawToCollection($statement->fetchAll());
    }
}