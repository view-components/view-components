<?php

namespace Nayjest\ViewComponents\Data;

use Nayjest\ViewComponents\Data\ProcessingServices\ProcessingServiceInterface;
use Traversable;

abstract class AbstractDataProvider implements DataProviderInterface
{
    /** @var ProcessingServiceInterface */
    protected $processingService;

    /** @var OperationsCollection */
    private $operationsCollection;

    public function count()
    {
        return $this->processingService->count();
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
        return $this->processingService->getProcessedData();
    }
}
