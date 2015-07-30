<?php

namespace Presentation\Framework\Data;

use Presentation\Framework\Data\ProcessingServices\ArrayProcessingService;
use Presentation\Framework\Data\ProcessorResolvers\ArrayProcessorResolver;
use Presentation\Framework\Data\ProcessorResolvers\ProcessorResolverInterface;

class ArrayDataProvider extends AbstractDataProvider
{
    public function __construct(
        $src,
        array $operations = [],
        ProcessorResolverInterface $processorResolver = null
    )
    {
        $this->operations()->setItems($operations);
        $this->processingService = new ArrayProcessingService(
            $processorResolver ?: new ArrayProcessorResolver(),
            $this->operations(),
            $src
        );
    }
}
