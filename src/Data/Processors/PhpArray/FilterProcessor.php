<?php

namespace Nayjest\ViewComponents\Data\Processors\PhpArray;

use Nayjest\ViewComponents\Data\Operations\Filter;
use Nayjest\ViewComponents\Data\Operations\OperationInterface;
use InvalidArgumentException;
use Nayjest\ViewComponents\Data\Processors\ProcessorInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class FilterProcessor implements ProcessorInterface
{
    /**
     * @param $src
     * @param OperationInterface|Filter $operation
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
            case Filter::OPERATOR_EQ:
                return $value == $expected;
            case Filter::OPERATOR_GT:
                return $value > $expected;
            case Filter::OPERATOR_GTE:
                return $value >= $expected;
            case Filter::OPERATOR_LT:
                return $value < $expected;
            case Filter::OPERATOR_LTE:
                return $value <= $expected;
            case Filter::OPERATOR_NOT_EQ:
                return $value != $expected;
            default:
                throw new InvalidArgumentException(
                    'Unsupported operator ' . $operator
                );
        }
    }
}
