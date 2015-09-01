<?php

namespace Presentation\Framework\Test\Components;

use PHPUnit_Framework_TestCase;
use Presentation\Framework\Component\Dummy;

class DummyTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $dummy1 = new Dummy();
        $dummy1->someProp = 'someVal';

        $dummy2 = Dummy::getInstance();
        $dummy3 = Dummy::getInstance();

        self::assertEquals($dummy2, $dummy3);
        self::assertNotEquals($dummy1, $dummy2);
        self::assertEquals('', $dummy1->render());
    }
}