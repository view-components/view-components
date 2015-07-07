<?php
namespace Presentation\Framework\Test;

use Presentation\Framework\Test\Mock\ChildClass;
use Presentation\Framework\Test\Mock\ParentClass;
use Presentation\Framework\Test\Mock\ParentClassWithDefaults;
use PHPUnit_Framework_TestCase;

class ParentTraitTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $parent = new ParentClass();
        self::assertInstanceOf('\Presentation\Framework\Structure\NodesCollection', $parent->components());
        self::assertTrue($parent->components()->isEmpty());
    }

    public function testWithDefaults()
    {
        $parent = new ParentClassWithDefaults();
        self::assertTrue($parent->components()->count() === 2);
        $parent->setComponents([]);
        self::assertTrue($parent->components()->count() === 0);
    }
}
