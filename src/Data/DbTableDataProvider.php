<?php

namespace ViewComponents\ViewComponents\Data;

use ViewComponents\ViewComponents\Data\DbTable\Query;
use ViewComponents\ViewComponents\Data\Operation\OperationInterface;
use ViewComponents\ViewComponents\Data\ProcessingService\DbTableProcessingService;
use ViewComponents\ViewComponents\Data\ProcessorResolver\DbTableProcessorResolver;
use PDO;

class DbTableDataProvider extends AbstractDataProvider
{

    /**
     * Constructor.
     *
     * @param PDO $connection
     * @param string $table
     * @param OperationInterface[] $operations
     */
    public function __construct(PDO $connection, $table, array $operations = [])
    {
        $this->operations()->set($operations);
        $this->processingService = new DbTableProcessingService(
            new DbTableProcessorResolver(),
            $this->operations(),
            new Query($connection, $table)
        );
    }
}
