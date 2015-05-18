<?php

namespace Nayjest\ViewComponents\Data\Processors\DbTable;

use Nayjest\ViewComponents\Data\DbTable\Query;
use Nayjest\ViewComponents\Data\Operations\OperationInterface;
use Nayjest\ViewComponents\Data\Operations\Sorting;
use Nayjest\ViewComponents\Data\Processors\ProcessorInterface;

class SortingProcessor implements ProcessorInterface
{
    /**
     * @param Query $src
     * @param OperationInterface|Sorting $operation
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
