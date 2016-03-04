<?php

namespace ViewComponents\ViewComponents\Data\Processor\DbTable;

use ViewComponents\ViewComponents\Data\DbTable\Query;
use ViewComponents\ViewComponents\Data\Operation\FilterOperation;
use ViewComponents\ViewComponents\Data\Operation\OperationInterface;
use ViewComponents\ViewComponents\Data\Processor\ProcessorInterface;

class FilterProcessor implements ProcessorInterface
{
    /**
     * Applies operation to source and returns modified source.
     *
     * @param Query $src
     * @param OperationInterface|FilterOperation $operation
     * @return Query
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
