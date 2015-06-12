<?php

namespace Nayjest\ViewComponents\Data\Processors\DbTable;

use Nayjest\ViewComponents\Data\DbTable\Query;
use Nayjest\ViewComponents\Data\Operations\OperationInterface;
use Nayjest\ViewComponents\Data\Operations\SortOperation;
use Nayjest\ViewComponents\Data\Processors\ProcessorInterface;

class SortProcessor implements ProcessorInterface
{
    /**
     * @param Query $src
     * @param OperationInterface|SortOperation $operation
     * @return mixed
     */
    public function process($src, OperationInterface $operation)
    {
        $field = $operation->getField();
        $order = $operation->getOrder();
        $src->order .= "ORDER BY $field $order";
        return $src;
    }
}
