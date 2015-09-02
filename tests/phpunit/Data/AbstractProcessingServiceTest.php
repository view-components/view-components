<?php

namespace Presentation\Framework\Test\Data;

use LogicException;
use Presentation\Framework\Data\Operation\FilterOperation;
use Presentation\Framework\Data\OperationsCollection;
use Presentation\Framework\Data\ProcessingService\ArrayProcessingService;
use PHPUnit_Framework_TestCase;

abstract class AbstractProcessingServiceTest extends PHPUnit_Framework_TestCase
{
    /** @var  ArrayProcessingService */
    protected $service;

    protected $data;
    /** @var  OperationsCollection */
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
            $this->service->count()
        );
    }

    public function testOperations()
    {
        $op = new FilterOperation('id','<=', 3);
        $this->operations->add($op);
        self::assertEquals(3, $this->service->count());
        $this->operations->remove($op);
        self::assertEquals($this->totalCount, $this->service->count());
    }
}
