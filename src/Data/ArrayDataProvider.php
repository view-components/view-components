<?php

namespace ViewComponents\ViewComponents\Data;

use ViewComponents\ViewComponents\Data\ProcessingService\ArrayProcessingService;
use ViewComponents\ViewComponents\Data\ProcessorResolver\ArrayProcessorResolver;
use ViewComponents\ViewComponents\Data\ProcessorResolver\ProcessorResolverInterface;

class ArrayDataProvider extends AbstractDataProvider
{
    public function __construct(
        $src,
        array $operations = [],
        ProcessorResolverInterface $processorResolver = null
    )
    {
        $this->operations()->set($operations);
        $this->processingService = new ArrayProcessingService(
            $processorResolver ?: new ArrayProcessorResolver(),
            $this->operations(),
            $src
        );
    }
}
