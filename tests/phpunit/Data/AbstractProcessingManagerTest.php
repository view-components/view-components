<?php

namespace Nayjest\ViewComponents\Test\Data;

use Exception;
use Nayjest\ViewComponents\Data\ArrayProcessingManager;
use Nayjest\ViewComponents\Data\Operations\Filter;
use Nayjest\ViewComponents\Data\OperationsCollection;
use PHPUnit_Framework_TestCase;

abstract class AbstractProcessingManagerTest extends PHPUnit_Framework_TestCase
{
    /** @var  ArrayProcessingManager */
    protected $manager;
    protected $data;
    /** @var  OperationsCollection */
    protected $operations;

    protected $totalCount;

    public function setUp()
    {
        throw new Exception('Override me!');
    }

//    public function testGetSource()
//    {
//        self::assertEquals($this->data, $this->manager->getDataSource());
//
//        // do some stuff
//        $op = new Filter('id','<=', 3);
//        $this->operations->add($op);
//
//        // test again
//        self::assertEquals($this->data, $this->manager->getDataSource());
//
//    }

    public function testGetProcessedData()
    {
        self::assertEquals(
            $this->totalCount,
            $this->manager->count()
        );
    }

    public function testOperations()
    {
        $op = new Filter('id','<=', 3);
        $this->operations->add($op);
        self::assertEquals(3, $this->manager->count());
        $this->operations->remove($op);
        self::assertEquals($this->totalCount, $this->manager->count());
    }
}
