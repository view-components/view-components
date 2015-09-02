<?php
namespace Presentation\Framework\Data\Processor;

use Presentation\Framework\Data\Operation\PaginateOperation;

abstract class AbstractPaginateProcessor implements ProcessorInterface
{
    protected function getOffset(PaginateOperation $operation)
    {
        return ($operation->getPageNumber() - 1) * $operation->getPageSize();
    }

}
