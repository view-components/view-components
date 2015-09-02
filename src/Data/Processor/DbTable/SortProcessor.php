<?php

namespace Presentation\Framework\Data\Processor\DbTable;

use Presentation\Framework\Data\DbTable\Query;
use Presentation\Framework\Data\Operation\OperationInterface;
use Presentation\Framework\Data\Operation\SortOperation;
use Presentation\Framework\Data\Processor\ProcessorInterface;

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
