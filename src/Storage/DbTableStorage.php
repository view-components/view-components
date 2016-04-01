<?php

namespace ViewComponents\ViewComponents\Storage;

use InvalidArgumentException;
use PDO;
use PDOException;

/**
 * Key-value storage based on DB table.
 */
class DbTableStorage implements KeyValueStorageInterface
{
    /**
     * @var PDO
     */
    private $connection;
    /**
     * @var string
     */
    private $tableName;
    /**
     * @var string
     */
    private $keyField;
    /**
     * @var string
     */
    private $valueField;

    private $storageReady = false;
    /**
     * @var bool
     */
    private $createTableIfNotExists;

    /**
     * DbTableStorage constructor.
     *
     * @param PDO $connection
     * @param string $tableName
     * @param string $keyField
     * @param string $valueField
     * @param bool $createTableIfNotExists
     */
    public function __construct(
        PDO $connection,
        $tableName,
        $keyField = 'id',
        $valueField = 'data',
        $createTableIfNotExists = false
    ) {
        $this->connection = $connection;
        $this->tableName = $tableName;
        $this->keyField = $keyField;
        $this->valueField = $valueField;
        $this->createTableIfNotExists = $createTableIfNotExists;
    }

    public function has($key)
    {
        $this->prepareStorage();
        $statement = $this->connection->prepare("
            SELECT count({$this->keyField}) FROM {$this->tableName}
            WHERE {$this->keyField} = :key;
        ");
        $statement->execute([':key' => $key]);
        return $statement->fetch(PDO::FETCH_NUM)[0] == 1;
    }

    public function delete($key)
    {
        if (!$this->has($key)) {
            throw new InvalidArgumentException(
                'Trying to delete not existing item from storage'
            );
        }
        $statement = $this->connection->prepare("
            DELETE FROM {$this->tableName}
            WHERE {$this->keyField} = :key
        ");
        $statement->execute([':key' => $key]);
        return $this;
    }

    public function get($key)
    {
        if (!$this->has($key)) {
            throw new InvalidArgumentException(
                'Trying to receive not existing item from storage'
            );
        }
        $statement = $this->connection->prepare("
            SELECT $this->valueField FROM {$this->tableName}
            WHERE {$this->keyField} = :key
        ");
        $statement->execute([':key' => $key]);
        return $statement->fetch(PDO::FETCH_NUM)[0];
    }

    public function set($key, $value)
    {
        $this->prepareStorage();
        if ($this->has($key)) {
            $this->delete($key);
        }
        $this->connection->prepare("
            INSERT INTO {$this->tableName}
            ($this->keyField, $this->valueField)
            VALUES(:key, :value)
        ")->execute([
            ':key' => $key,
            ':value' => $value
        ]);
        return $this;
    }

    protected function tableExists()
    {
        $errorMode = $this->connection->getAttribute(PDO::ATTR_ERRMODE);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $this->connection->query("SELECT 1 FROM {$this->tableName} LIMIT 1");
            $result = true;
        } catch (PDOException $e) {
            $result = false;
        }
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, $errorMode);
        return $result;
    }

    protected function createTable()
    {
        $this->connection->exec("
          CREATE TABLE IF NOT EXISTS {$this->tableName} (
                id varchar(255) NOT NULL,
                data text,
                PRIMARY KEY (id)
              );
        ");
    }

    protected function prepareStorage()
    {
        if ($this->createTableIfNotExists && !$this->storageReady && !$this->tableExists()) {
            $this->createTable();
            $this->storageReady = true;
        }
    }
}
