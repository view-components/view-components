<?php
namespace Nayjest\ViewComponents\Test;

use Nayjest\ViewComponents\Test\Mock\ChildClass;
use Nayjest\ViewComponents\Test\Mock\ParentClass;
use Nayjest\ViewComponents\Test\Mock\ParentClassWithDefaults;
use PHPUnit_Framework_TestCase;

class ParentTraitTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $parent = new ParentClass();
        self::assertInstanceOf('\Nayjest\ViewComponents\Structure\Collection', $parent->components());
        self::assertTrue($parent->components()->isEmpty());
    }

    public function testWithDefaults()
    {
        $parent = new ParentClassWithDefaults();
        self::assertTrue($parent->components()->getSize() === 2);
        $parent->setComponents([]);
        self::assertTrue($parent->components()->getSize() === 0);
    }
}
