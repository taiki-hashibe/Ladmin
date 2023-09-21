<?php

namespace LowB\Ladmin\Support\Query;

use Exception;

class LadminQueryManager
{
    protected array $queries = [];

    public function register(LadminQuery $query)
    {
        $this->queries[] = $query;
    }

    public function getQuery(string $tableName): LadminQuery
    {
        foreach ($this->queries as $query) {
            if ($query->getTable() === $tableName) {
                return $query;
            }
        }
        throw new Exception("Unregistered query or table not found: $tableName");
    }
}
