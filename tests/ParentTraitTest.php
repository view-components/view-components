<?php
namespace Nayjest\ViewComponents\Test;

use Nayjest\ViewComponents\Test\Mock\ChildClass;
use Nayjest\ViewComponents\Test\Mock\ParentClass;
use PHPUnit_Framework_TestCase;

class ParentTraitTest extends PHPUnit_Framework_TestCase
{
    public function test(){
        $parent = new ParentClass();
        $this->assertInstanceOf('\Nayjest\ViewComponents\Structure\Collection', $parent->components());
        $this->assertTrue($parent->components()->isEmpty());
    }
}