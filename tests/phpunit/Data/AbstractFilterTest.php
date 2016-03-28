<?php

namespace ViewComponents\ViewComponents\Test\Data;

use Nayjest\Collection\Extended\ObjectCollection;
use ViewComponents\TestingHelpers\Test\DefaultFixture;
use ViewComponents\ViewComponents\Data\DataProviderInterface;
use ViewComponents\ViewComponents\Data\Operation\FilterOperation;

abstract class AbstractFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return DataProviderInterface
     */
    abstract protected function getDataProvider();

    public function provider()
    {
        $value = 3;
        $field = 'id';
        $operations = [
            FilterOperation::OPERATOR_EQ => function ($item) use ($value, $field) {
                return $item->{$field} == $value;
            },
            FilterOperation::OPERATOR_NOT_EQ => function ($item) use ($value, $field) {
                return $item->{$field} != $value;
            },
            FilterOperation::OPERATOR_GT => function ($item) use ($value, $field) {
                return $item->{$field} > $value;
            },
            FilterOperation::OPERATOR_LT => function ($item) use ($value, $field) {
                return $item->{$field} < $value;
            },
            FilterOperation::OPERATOR_LTE => function ($item) use ($value, $field) {
                return $item->{$field} <= $value;
            },
            FilterOperation::OPERATOR_GTE => function ($item) use ($value, $field) {
                return $item->{$field} >= $value;
            },
        ];
        $data = [];
        foreach ($operations as $operation => $fn) {
            $data[] = [
                [new FilterOperation($field, $operation, $value)],
                DefaultFixture::getCollection()->filter($fn)
            ];
        }
        return $data;
    }

    public function multiOpProvider()
    {
        $data = $this->provider();
        $newData = [];
        foreach($data as $item) {
            $newData[] = $item;
            $newData[] = [
                array_merge(
                    $item[0],
                    [new FilterOperation('role', FilterOperation::OPERATOR_NOT_EQ, 'Manager')]
                ),
                $item[1]->filter(function($item) {
                    return $item->role != 'Manager';
                }),
            ];
        }
        return $newData;
    }

    /**
     * @dataProvider multiOpProvider
     *
     * @param FilterOperation[] $operations
     * @param ObjectCollection $assertData
     */
    public function test($operations, $assertData)
    {
        $provider = $this->getDataProvider();
        $provider->operations()->addMany($operations);
        $processedData = iterator_to_array($provider->getIterator());
        $message = 'Testing Filter ' .
            ((count($operations) == 1) ? (
                $operations[0]->getField()
                . ' '
                . $operations[0]->getOperator()
                . ' '
                . $operations[0]->getValue()
            ) : '')
            . ' Expected count: '
            . count($assertData)
            . ', actual:'
            . count($processedData);
        self::assertEquals(
            count($assertData),
            count($processedData),
            $message
        );
        //echo "\r\n\t $message";
    }
}
