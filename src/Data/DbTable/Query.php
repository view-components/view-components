<?php

namespace ViewComponents\ViewComponents\Data\DbTable;

use PDO;
use PDOStatement;
use RuntimeException;

/**
 * Class Query
 *
 * @internal
 */
class Query
{
    /** @var string  */
    protected $table;

    /** @var PDO  */
    public $connection;
    public $conditions = [];
    public $bindings = [];
    public $order = '';
    public $select = '*';
    public $limit = '';
    public $offset = '';

    /**
     * @param PDO $connection
     * @param string $table
     */
    public function __construct(PDO $connection, $table)
    {
        $this->connection = $connection;
        $this->table = $table;
    }

    public function getSql()
    {
        $where = (count($this->conditions) === 0)
            ? ''
            : 'WHERE ' . implode(' and ', $this->conditions);
        $sql = "SELECT $this->select FROM $this->table $where $this->order $this->limit $this->offset";
        return $sql;
    }

    protected function getPdoStatement()
    {
        return $this->connection->prepare($this->getSql());
    }

    /**
     * @return PDOStatement
     */
    public function execute()
    {
        $statement = $this->getPdoStatement();
        $result = $statement->execute($this->bindings);
        if (!$result) {
            $errorInfo = $statement->errorInfo();
            throw new RuntimeException(
                $errorInfo[1],
                $errorInfo[2]
            );
        }
        return $statement;
    }

    /**
     * @return int
     */
    public function count()
    {
        $query = clone $this;
        $query->select = 'count(*)';
        return (int)$query->execute()->fetch(PDO::FETCH_NUM)[0];
    }
}
