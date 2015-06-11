<?php

namespace Nayjest\ViewComponents\Data;

use Traversable;

abstract class AbstractDataProvider implements DataProviderInterface
{
    /** @var ArrayProcessingManager */
    protected $processingManager;

    /** @var OperationsCollection */
    private $operationsCollection;

    public function count()
    {
        return $this->processingManager->count();
    }

    /**
     * @return OperationsCollection
     */
    public function operations()
    {
        if (null === $this->operationsCollection) {
            $this->operationsCollection = new OperationsCollection();
        }
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
