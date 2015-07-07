<?php

namespace Presentation\Framework\Data;

use Presentation\Framework\Data\DbTable\Query;
use Presentation\Framework\Data\Operations\OperationInterface;
use Presentation\Framework\Data\ProcessingServices\DbTableProcessingService;
use Presentation\Framework\Data\ProcessorResolvers\DbTableProcessorResolver;
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
        $this->processingService = new DbTableProcessingService(
            new DbTableProcessorResolver(),
            $this->operations(),
            new Query($connection, $table)
        );
    }
}
