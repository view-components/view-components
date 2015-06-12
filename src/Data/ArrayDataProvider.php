<?php

namespace Nayjest\ViewComponents\Data;

use Nayjest\ViewComponents\Data\ProcessingServices\ArrayProcessingService;
use Nayjest\ViewComponents\Data\ProcessorResolvers\ArrayProcessorResolver;
use Nayjest\ViewComponents\Data\ProcessorResolvers\ProcessorResolverInterface;

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
