<?php
namespace Nayjest\ViewComponents\Test\Data;

use Nayjest\ViewComponents\Data\ArrayDataProvider;
use Nayjest\ViewComponents\Data\Operations\Filter;
use Nayjest\ViewComponents\Data\Operations\Sorting;
use Nayjest\ViewComponents\Data\ArrayProcessingService;
use PHPUnit_Framework_TestCase;

class ArrayDataProviderTest extends PHPUnit_Framework_TestCase
{
    protected function getData()
    {
        return [
            [
                'id' => 1,
            ],
            [
                'id' => 2,
            ],
            [
                'id' => 3,
            ],
            [
                'id' => 4,
            ],
            [
                'id' => 5,
            ],
        ];
    }

    protected function makeProvider()
    {
        return new ArrayDataProvider($this->getData());
    }

    public function testFiltering()
    {

        $provider = $this->makeProvider();
        $provider->operations()->add(
            (new Filter)
                ->setField('id')
                ->setOperator(Filter::OPERATOR_GT)
                ->setValue(3)
        );
        $provider->operations()->add(
            new Filter('id', '<', 5)
        );

        $iterator = $provider->getIterator();
        $rows = iterator_to_array($iterator);

        self::assertEquals(1, count($rows));
        $row = array_pop($rows);
        self::assertEquals(4, $row->id);
    }

    public function testSorting()
    {
        $provider = $this->makeProvider();
        $sorting = new Sorting('id', Sorting::DESC);
        $provider->operations()->set([$sorting]);
        $res = '';
        foreach ($provider as $row) {
            $res .= $row->id;
        }
        self::assertEquals('54321', $res);

        // Test changing operations
        $provider->operations()->add(
            new Filter('id', Filter::OPERATOR_NOT_EQ, 3)
        );
        $res = '';
        foreach ($provider as $row) {
            $res .= $row->id;
        }
        self::assertEquals('5421', $res);
    }

    public function testCount()
    {
        $provider = $this->makeProvider();
        self::assertCount(5, $provider);
    }
}