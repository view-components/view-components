<?php

namespace ViewComponents\ViewComponents\Data\Processor\PhpArray;

use ViewComponents\ViewComponents\Data\Operation\FilterOperation;
use ViewComponents\ViewComponents\Data\Operation\OperationInterface;
use InvalidArgumentException;
use ViewComponents\ViewComponents\Data\Processor\ProcessorInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class FilterProcessor implements ProcessorInterface
{
    /**
     * @param $src
     * @param OperationInterface|FilterOperation $operation
     * @return mixed
     *
     * @todo Cache propertyAccessor
     */
    public function process($src, OperationInterface $operation)
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        $res = [];
        foreach ($src as $row) {
            $value = $accessor->getValue($row, $operation->getField());
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
