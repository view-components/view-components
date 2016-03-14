<?php

namespace ViewComponents\ViewComponents\Test\Data;

use LogicException;
use ViewComponents\ViewComponents\Data\Operation\FilterOperation;
use ViewComponents\ViewComponents\Data\OperationCollection;
use ViewComponents\ViewComponents\Data\ProcessingService\ArrayProcessingService;
use PHPUnit_Framework_TestCase;

abstract class AbstractProcessingServiceTest extends PHPUnit_Framework_TestCase
{
    /** @var  ArrayProcessingService */
    protected $service;

    protected $data;
    /** @var  OperationCollection */
    protected $operations;

    protected $totalCount;

    public function setUp()
    {
        throw new LogicException('Override me!');
    }

    public function testGetProcessedData()
    {
        self::assertEquals(
            $this->totalCount,
            $this->service->count(),
            'Test ' . get_class($this->service) . '::count()'
        );
    }

    public function testOperations()
    {
        $op = new FilterOperation('id','<=', 3);
        $this->operations->add($op);
        self::assertEquals(3, $this->service->count(), 'Test filtering');
        $this->operations->remove($op);
        self::assertEquals($this->totalCount, $this->service->count(), 'Test recalc. after removing operation');
    }

    public function testGetField()
    {
        $data  = $this->service->getProcessedData();
        foreach($data as $item) {
            $this->assertTrue(!empty($item->id));
        }
    }
}
