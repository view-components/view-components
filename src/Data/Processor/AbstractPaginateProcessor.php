<?php
namespace ViewComponents\ViewComponents\Data\Processor;

use ViewComponents\ViewComponents\Data\Operation\PaginateOperation;

abstract class AbstractPaginateProcessor implements ProcessorInterface
{
    protected function getOffset(PaginateOperation $operation)
    {
        return ($operation->getPageNumber() - 1) * $operation->getPageSize();
    }
}
