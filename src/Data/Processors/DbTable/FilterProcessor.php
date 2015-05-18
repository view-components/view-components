<?php

namespace Nayjest\ViewComponents\Data\Processors\DbTable;

use Nayjest\ViewComponents\Data\DbTable\Query;
use Nayjest\ViewComponents\Data\Operations\Filter;
use Nayjest\ViewComponents\Data\Operations\OperationInterface;
use Nayjest\ViewComponents\Data\Processors\ProcessorInterface;

class FilterProcessor implements ProcessorInterface
{
    /**
     * @param Query $src
     * @param OperationInterface|Filter $operation
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
