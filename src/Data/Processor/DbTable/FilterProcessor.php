<?php

namespace Presentation\Framework\Data\Processor\DbTable;

use Presentation\Framework\Data\DbTable\Query;
use Presentation\Framework\Data\Operation\FilterOperation;
use Presentation\Framework\Data\Operation\OperationInterface;
use Presentation\Framework\Data\Processor\ProcessorInterface;

class FilterProcessor implements ProcessorInterface
{
    /**
     * @param Query $src
     * @param OperationInterface|FilterOperation $operation
     * @return mixed
     */
    public function process($src, OperationInterface $operation)
    {
        $expected = $operation->getValue();
        $operator = $operation->getOperator();
        $field = $operation->getField();
        $src->conditions[]  = "$field $operator :$field";
        $src->bindings[':' . $field] = $expected;
        return $src;
    }

}
