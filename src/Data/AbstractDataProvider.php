<?php

namespace Nayjest\ViewComponents\Data;

use ArrayIterator;

class AbstractDataProvider implements DataProviderInterface
{
    /** @var  ProcessingManager */
    protected $processingManager;
    protected $operationsCollection;

    public function operations()
    {
        return $this->operationsCollection;
    }

    public function getIterator()
    {
        return new ArrayIterator(
            $this->processingManager->getProcessedData()
        );
    }
}
