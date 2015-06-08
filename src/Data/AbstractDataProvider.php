<?php

namespace Nayjest\ViewComponents\Data;

use Traversable;

class AbstractDataProvider implements DataProviderInterface
{
    /** @var ArrayProcessingManager */
    protected $processingManager;

    /** @var OperationsCollection */
    private $operationsCollection;

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
