<?php

namespace ViewComponents\ViewComponents\Data\Processor\DbTable;

use ViewComponents\ViewComponents\Data\DbTable\Query;
use ViewComponents\ViewComponents\Data\Operation\OperationInterface;
use ViewComponents\ViewComponents\Data\Operation\SortOperation;
use ViewComponents\ViewComponents\Data\Processor\ProcessorInterface;

class SortProcessor implements ProcessorInterface
{
    /**
     * Applies operation to source and returns modified source.
     *
     * @param Query $src
     * @param OperationInterface|SortOperation $operation
     * @return Query
     */
    public function process($src, OperationInterface $operation)
    {
        $field = $operation->getField();
        $order = $operation->getOrder();
        $src->order .= "ORDER BY $field $order";
        return $src;
    }
}
