<?php

namespace Presentation\Framework\Data\ProcessorResolver;

use Presentation\Framework\Data\Operation\FilterOperation;
use Presentation\Framework\Data\Operation\PaginateOperation;
use Presentation\Framework\Data\Operation\SortOperation;
use Presentation\Framework\Data\Processor\PhpArray\FilterProcessor;
use Presentation\Framework\Data\Processor\PhpArray\PaginateProcessor;
use Presentation\Framework\Data\Processor\PhpArray\SortProcessor;

class ArrayProcessorResolver extends ProcessorResolver
{
    public function __construct()
    {
        $this->register(SortOperation::class, SortProcessor::class);
        $this->register(FilterOperation::class, FilterProcessor::class);
        $this->register(PaginateOperation::class, PaginateProcessor::class);
    }
}
