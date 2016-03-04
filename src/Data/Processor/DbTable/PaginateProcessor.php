<?php
namespace ViewComponents\ViewComponents\Data\Processor\DbTable;

use ViewComponents\ViewComponents\Data\DbTable\Query;
use ViewComponents\ViewComponents\Data\Operation\OperationInterface;
use ViewComponents\ViewComponents\Data\Operation\PaginateOperation;
use ViewComponents\ViewComponents\Data\Processor\AbstractPaginateProcessor;

class PaginateProcessor extends AbstractPaginateProcessor
{
    /**
     * Applies operation to source and returns modified source.
     *
     * @param Query $src
     * @param OperationInterface|PaginateOperation $operation
     * @return Query
     */
    public function process($src, OperationInterface $operation)
    {
        $src->offset = 'OFFSET ' . $this->getOffset($operation);
        $src->limit = 'LIMIT ' . $operation->getPageSize();
        return $src;
    }
}
