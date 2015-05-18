<?php

namespace Nayjest\ViewComponents\Data\DbTable;

use PDO;

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
        $sql = "SELECT * FROM $this->table $where $this->order";
        return $sql;
    }

    public function getPdoStatement()
    {
        return $this->connection->prepare($this->getSql());
    }

}