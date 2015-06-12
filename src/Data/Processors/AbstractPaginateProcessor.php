<?php
namespace Nayjest\ViewComponents\Data\Processors;

use Nayjest\ViewComponents\Data\Operations\PaginateOperation;

abstract class AbstractPaginateProcessor implements ProcessorInterface
{
    protected function getOffset(PaginateOperation $operation)
    {
        return ($operation->getPageNumber() - 1) * $operation->getPageSize();
    }

}
