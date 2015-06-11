<?php
namespace Nayjest\ViewComponents\Data\Processors;

use Nayjest\ViewComponents\Data\Operations\Paginate;

abstract class AbstractPaginateProcessor implements ProcessorInterface
{
    protected function getOffset(Paginate $operation)
    {
        return ($operation->getPageNumber() - 1) * $operation->getPageSize();
    }

}
