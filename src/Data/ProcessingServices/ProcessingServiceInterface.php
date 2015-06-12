<?php

namespace Nayjest\ViewComponents\Data\ProcessingServices;

use Countable;
use Nayjest\ViewComponents\Data\OperationsCollection;
use Nayjest\ViewComponents\Data\ProcessorResolvers\ProcessorResolverInterface;
use Traversable;

interface ProcessingServiceInterface extends Countable
{

    public function __construct(
        ProcessorResolverInterface $processorResolver,
        OperationsCollection $operations,
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
