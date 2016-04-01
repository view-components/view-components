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

    protected $dataRowClass;

    /** @var PDO  */
    public $connection;
    public $conditions = [];
    public $bindings = [];
    public $order = '';
    public $select = '*';
    public $limit = '';
    public $offset = '';

    /**
     * Constructor.
     *
     * @param PDO $connection
     * @param string $table
     * @param string $dataRowClass specify class if you need to fetch data to specific class instances
     */
    public function __construct(PDO $connection, $table, $dataRowClass = null)
    {
        $this->connection = $connection;
        $this->table = $table;
    }

    /**
     * Returns generated SQL.
     *
     * @return string
     */
    public function getSql()
    {
        $where = (count($this->conditions) === 0)
            ? ''
            : 'WHERE ' . implode(' and ', $this->conditions);
        $sql = "SELECT $this->select FROM $this->table $where $this->order $this->limit $this->offset";
        return $sql;
    }

    /**
     * Prepares a PDOStatement for execution and returns it.
     *
     * @return PDOStatement
     */
    protected function getPdoStatement()
    {
        $statement = $this->connection->prepare($this->getSql());
        if ($this->dataRowClass !== null) {
            $statement->setFetchMode(PDO::FETCH_CLASS, $this->dataRowClass);
        } else {
            $statement->setFetchMode(PDO::FETCH_OBJ);
        }
        return $statement;
    }

    /**
     * Executes query.
     *
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
     * Returns records count.
     * Executes separate SQL query to count records.
     *
     * @return int
     */
    public function count()
    {
        $query = clone $this;
        $query->select = 'count(*)';
        return (int)$query->execute()->fetch(PDO::FETCH_NUM)[0];
    }
}
