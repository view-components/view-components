<?php
namespace Presentation\Framework\Test\Data;

use Presentation\Framework\Data\ArrayDataProvider;
use Presentation\Framework\Data\Operations\FilterOperation;
use Presentation\Framework\Data\Operations\SortOperation;
use Presentation\Framework\Data\ArrayProcessingService;
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
        $provider->operations()->addItem(
            (new FilterOperation)
                ->setField('id')
                ->setOperator(FilterOperation::OPERATOR_GT)
                ->setValue(3)
        );
        $provider->operations()->addItem(
            new FilterOperation('id', '<', 5)
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
        $sorting = new SortOperation('id', SortOperation::DESC);
        $provider->operations()->setItems([$sorting]);
        $res = '';
        foreach ($provider as $row) {
            $res .= $row->id;
        }
        self::assertEquals('54321', $res);

        // Test changing operations
        $provider->operations()->addItem(
            new FilterOperation('id', FilterOperation::OPERATOR_NOT_EQ, 3)
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