<?php

namespace ViewComponents\ViewComponents\Data\ProcessingService;

use Countable;
use ViewComponents\ViewComponents\Data\OperationCollection;
use ViewComponents\ViewComponents\Data\ProcessorResolver\ProcessorResolverInterface;
use Traversable;

interface ProcessingServiceInterface extends Countable
{

    /**
     * ProcessingServiceInterface constructor.
     * @param ProcessorResolverInterface $processorResolver
     * @param OperationCollection $operations
     * @param $dataSource
     */
    public function __construct(
        ProcessorResolverInterface $processorResolver,
        OperationCollection $operations,
        $dataSource
    );

    /**
     * @return Traversable
     */
    public function getProcessedData();

    /**
     * Returns count of processed items after applying all operations.
     *
     * @return int
     */
    public function count();
}
