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
            $testedValue = mp\getValue($row, $operation->getField());
            $argument = $operation->getValue();
            $operator = $operation->getOperator();
            if ($this->checkValue($testedValue, $operator, $argument)) {
                $res[] = $row;
            }
        }
        return $res;
    }

    /**
     * @param $testedValue
     * @param string $operator
     * @param $argument
     * @return bool
     * @throws InvalidArgumentException
     *
     */
    protected function checkValue($testedValue, $operator, $argument)
    {
        switch ($operator) {
            case FilterOperation::OPERATOR_EQ:
                return $testedValue == $argument;
            case FilterOperation::OPERATOR_GT:
                return $testedValue > $argument;
            case FilterOperation::OPERATOR_GTE:
                return $testedValue >= $argument;
            case FilterOperation::OPERATOR_LT:
                return $testedValue < $argument;
            case FilterOperation::OPERATOR_LTE:
                return $testedValue <= $argument;
            case FilterOperation::OPERATOR_NOT_EQ:
                return $testedValue != $argument;
            case FilterOperation::OPERATOR_STR_CONTAINS:
                return strpos($testedValue, $argument) !== false;
            case FilterOperation::OPERATOR_STR_STARTS_WITH:
                return strpos($testedValue, $argument) === 0;
            case FilterOperation::OPERATOR_STR_ENDS_WITH:
                return strpos($testedValue, $argument, strlen($testedValue) - strlen($argument)) !== false;
            default:
                throw new InvalidArgumentException(
                    'Unsupported operator ' . $operator
                );
        }
    }
}
