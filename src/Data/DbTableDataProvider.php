<?php

namespace Nayjest\ViewComponents\Data;

use Nayjest\ViewComponents\Data\DbTable\Query;
use Nayjest\ViewComponents\Data\Operations\OperationInterface;
use PDO;

class DbTableDataProvider extends AbstractDataProvider
{

    /**
     * @param PDO $connection
     * @param string $table
     * @param OperationInterface[] $operations
     */
    public function __construct(PDO $connection, $table, array $operations = [])
    {
        $this->operationsCollection = new OperationsCollection();
        $this->operationsCollection->set($operations);

        $this->processingManager = new DbTableProcessingManager(
            new DbTableProcessorResolver(),
            $this->operationsCollection,
            new Query($connection, $table)
        );
    }
}
