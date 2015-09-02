<?php

namespace Presentation\Framework\Data\ProcessorResolver;

use Presentation\Framework\Data\Operation\FilterOperation;
use Presentation\Framework\Data\Operation\SortOperation;
use Presentation\Framework\Data\Processor\DbTable\FilterProcessor;
use Presentation\Framework\Data\Processor\DbTable\SortProcessor;

class DbTableProcessorResolver extends ProcessorResolver
{
    public function __construct()
    {
        $this->register(SortOperation::class, SortProcessor::class);
        $this->register(FilterOperation::class, FilterProcessor::class);
    }
}
