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
        $argument = $operation->getValue();
        $operator = $operation->getOperator();
        $field = $operation->getField();
        switch ($operator) {
            case FilterOperation::OPERATOR_STR_STARTS_WITH:
                $operator = FilterOperation::OPERATOR_LIKE;
                $argument .= '%';
                break;
            case FilterOperation::OPERATOR_STR_ENDS_WITH:
                $operator = FilterOperation::OPERATOR_LIKE;
                $argument = '%' . $argument;
                break;
            case FilterOperation::OPERATOR_STR_CONTAINS:
                $operator = FilterOperation::OPERATOR_LIKE;
                $argument = '%' . $argument . '%';
                break;
        }
        $src->conditions[]  = "$field $operator :$field";
        $src->bindings[':' . $field] = $argument;
        return $src;
    }
}
