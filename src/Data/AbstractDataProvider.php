<?php

namespace Nayjest\ViewComponents\Data;

use Traversable;

class AbstractDataProvider implements DataProviderInterface
{
    /** @var ProcessingManager */
    protected $processingManager;

    /** @var OperationsCollection */
    protected $operationsCollection;

    /**
     * @return OperationsCollection
     */
    public function operations()
    {
        return $this->operationsCollection;
    }

    /**
     * @return Traversable
     */
    public function getIterator()
    {
        return $this->processingManager->getProcessedData();
    }
}
