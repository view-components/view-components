<?php

namespace ViewComponents\ViewComponents\Data;

use ViewComponents\ViewComponents\Data\ProcessingService\ProcessingServiceInterface;
use Traversable;

abstract class AbstractDataProvider implements DataProviderInterface
{
    /** @var ProcessingServiceInterface */
    protected $processingService;

    /** @var OperationCollection */
    private $operationsCollection;

    public function count()
    {
        return $this->processingService->count();
    }

    /**
     * @return OperationCollection
     */
    public function operations()
    {
        if (null === $this->operationsCollection) {
            $this->operationsCollection = new OperationCollection();
        }
        return $this->operationsCollection;
    }

    /**
     * @return Traversable
     */
    public function getIterator()
    {
        return $this->processingService->getProcessedData();
    }
}
