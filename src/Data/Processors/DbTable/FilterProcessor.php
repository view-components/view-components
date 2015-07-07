<?php

namespace Presentation\Framework\Data\Processors\DbTable;

use Presentation\Framework\Data\DbTable\Query;
use Presentation\Framework\Data\Operations\FilterOperation;
use Presentation\Framework\Data\Operations\OperationInterface;
use Presentation\Framework\Data\Processors\ProcessorInterface;

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
