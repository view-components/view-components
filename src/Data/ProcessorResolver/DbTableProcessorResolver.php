<?php

namespace ViewComponents\ViewComponents\Data\ProcessorResolver;

use ViewComponents\ViewComponents\Data\Operation\FilterOperation;
use ViewComponents\ViewComponents\Data\Operation\PaginateOperation;
use ViewComponents\ViewComponents\Data\Operation\SortOperation;
use ViewComponents\ViewComponents\Data\Processor\DbTable\FilterProcessor;
use ViewComponents\ViewComponents\Data\Processor\DbTable\PaginateProcessor;
use ViewComponents\ViewComponents\Data\Processor\DbTable\SortProcessor;

class DbTableProcessorResolver extends ProcessorResolver
{
    public function __construct()
    {
        $this->register(SortOperation::class, SortProcessor::class);
        $this->register(FilterOperation::class, FilterProcessor::class);
        $this->register(PaginateOperation::class, PaginateProcessor::class);
    }
}
