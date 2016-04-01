<?php

namespace ViewComponents\ViewComponents\Data\ProcessorResolver;

use ViewComponents\ViewComponents\Data\Operation\FilterOperation;
use ViewComponents\ViewComponents\Data\Operation\PaginateOperation;
use ViewComponents\ViewComponents\Data\Operation\SortOperation;
use ViewComponents\ViewComponents\Data\Processor\PhpArray\FilterProcessor;
use ViewComponents\ViewComponents\Data\Processor\PhpArray\PaginateProcessor;
use ViewComponents\ViewComponents\Data\Processor\PhpArray\SortProcessor;

class ArrayProcessorResolver extends ProcessorResolver
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->register(SortOperation::class, SortProcessor::class);
        $this->register(FilterOperation::class, FilterProcessor::class);
        $this->register(PaginateOperation::class, PaginateProcessor::class);
    }
}
