<?php

namespace ViewComponents\ViewComponents\Data\Processor\PhpArray;

use ViewComponents\ViewComponents\Data\Operation\FilterOperation;
use ViewComponents\ViewComponents\Data\Operation\OperationInterface;
use InvalidArgumentException;
use ViewComponents\ViewComponents\Data\Processor\ProcessorInterface;
use mp;

class FilterProcessor implements ProcessorInterface
{
    /**
     * Applies operation to source and returns modified source.
     *
     * @param $src
     * @param OperationInterface|FilterOperation $operation
     * @return mixed
     */
    public function process($src, OperationInterface $operation)
    {
        $res = [];
        foreach ($src as $row) {
            $value = mp\getValue($row, $operation->getField());
            $expected = $operation->getValue();
            $operator = $operation->getOperator();
            if ($this->checkValue($value, $expected, $operator)) {
                $res[] = $row;
            }
        }
        return $res;
    }

    /**
     * @param $value
     * @param $expected
     * @param string $operator
     * @return bool
     * @throws InvalidArgumentException
     *
     */
    protected function checkValue($value, $expected, $operator)
    {
        switch ($operator) {
            case FilterOperation::OPERATOR_EQ:
                return $value == $expected;
            case FilterOperation::OPERATOR_GT:
                return $value > $expected;
            case FilterOperation::OPERATOR_GTE:
                return $value >= $expected;
            case FilterOperation::OPERATOR_LT:
                return $value < $expected;
            case FilterOperation::OPERATOR_LTE:
                return $value <= $expected;
            case FilterOperation::OPERATOR_NOT_EQ:
                return $value != $expected;
            default:
                throw new InvalidArgumentException(
                    'Unsupported operator ' . $operator
                );
        }
    }
}
