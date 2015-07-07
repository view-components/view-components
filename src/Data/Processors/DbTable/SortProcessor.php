<?php

namespace Presentation\Framework\Data\Processors\DbTable;

use Presentation\Framework\Data\DbTable\Query;
use Presentation\Framework\Data\Operations\OperationInterface;
use Presentation\Framework\Data\Operations\SortOperation;
use Presentation\Framework\Data\Processors\ProcessorInterface;

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
