<?php

namespace Nayjest\ViewComponents\Data;

use Nayjest\ViewComponents\Data\DbTable\Query;
use Nayjest\ViewComponents\Data\Operations\OperationInterface;
use Nayjest\ViewComponents\Data\ProcessorResolvers\DbTableProcessorResolver;
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
        $this->operations()->set($operations);
        $this->processingManager = new DbTableProcessingManager(
            new DbTableProcessorResolver(),
            $this->operations(),
            new Query($connection, $table)
        );
    }
}
