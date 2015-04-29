<?php

namespace Nayjest\ViewComponents\Data;


use ArrayIterator;
use IteratorAggregate;

class ArrayDataProvider implements IteratorAggregate
{
    protected $processingManager;
    protected $operationsCollection;

    public function __construct($src)
    {
        $this->operationsCollection = new OperationsCollection();
        $this->processingManager = new ProcessingManager(
            new ProcessorResolver(),
            $this->operationsCollection,
            $src
        );
    }

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
