<?php
namespace Presentation\Framework\Data\Processors;

use Presentation\Framework\Data\Operations\PaginateOperation;

abstract class AbstractPaginateProcessor implements ProcessorInterface
{
    protected function getOffset(PaginateOperation $operation)
    {
        return ($operation->getPageNumber() - 1) * $operation->getPageSize();
    }

}
