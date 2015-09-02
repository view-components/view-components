<?php

namespace Presentation\Framework\Data;

use Presentation\Framework\Data\ProcessingService\ArrayProcessingService;
use Presentation\Framework\Data\ProcessorResolver\ArrayProcessorResolver;
use Presentation\Framework\Data\ProcessorResolver\ProcessorResolverInterface;

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
