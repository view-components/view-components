<?php

namespace Presentation\Framework\Data\ProcessingService;

use Countable;
use Presentation\Framework\Data\OperationsCollection;
use Presentation\Framework\Data\ProcessorResolver\ProcessorResolverInterface;
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
