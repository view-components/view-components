<?php
namespace Nayjest\ViewComponents\Test;

use Nayjest\ViewComponents\Structure\Collection;
use Nayjest\ViewComponents\Test\Mock\ChildClass;
use Nayjest\ViewComponents\Test\Mock\ParentClass;
use PHPUnit_Framework_TestCase;

class CollectionTest extends PHPUnit_Framework_TestCase
{
    public function test(){
        $parent = new ParentClass();
        $collection = $parent->components();

        $this->assertTrue($collection->isEmpty());

        $child = new ChildClass();
        $this->assertTrue($child->getParent() === null);
        $collection->add($child);
        $this->assertTrue($collection->getSize() === 1);
        $this->assertTrue($child->getParent() === $parent);
        $collection->add($child);
        $this->assertTrue($collection->getSize() === 1, 'Item can\'t be added to collection twice.');

        $child2 = new ChildClass();
        $collection->add($child2);
        $this->assertTrue($collection->getSize() === 2);
        $collection->remove($child2);
        $this->assertTrue($collection->getSize() === 1);
        $this->assertTrue(
            $child2->getParent() === null,
            'Parent must be detached from child item after removing it from collection.'
        );
    }
}