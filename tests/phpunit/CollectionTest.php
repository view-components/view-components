<?php
namespace Nayjest\ViewComponents\Test;

use Nayjest\ViewComponents\Test\Mock\ChildClass;
use Nayjest\ViewComponents\Test\Mock\ParentClass;
use PHPUnit_Framework_TestCase;

class CollectionTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $parent = new ParentClass();
        $collection = $parent->components();

        self::assertTrue($collection->isEmpty());

        $child = new ChildClass();
        self::assertFalse($collection->has($child));
        self::assertTrue($child->getParent() === null);
        $collection->add($child);
        self::assertTrue($collection->count() === 1);
        self::assertTrue($collection->has($child));
        self::assertTrue($child->getParent() === $parent);

        $collection->add($child);
        self::assertTrue($collection->count() === 1, 'Item can\'t be added to collection twice.');

        $items = $collection->toArray();
        $item1 = array_pop($items);
        self::assertEquals($item1, $child);

        $child2 = new ChildClass();
        $collection->add($child2);
        self::assertTrue($collection->count() === 2);
        $collection->remove($child2);
        self::assertTrue($collection->count() === 1);
        self::assertTrue(
            $child2->getParent() === null,
            'Parent must be detached from child item after removing it from collection.'
        );

        // test clean
        $collection->set([$child, $child2]);
        $collection->clear();
        self::assertTrue(
            $collection->count() === 0,
            'Collection must be empty after calling clean()'
        );
        self::assertTrue(
            $child->getParent() === null,
            'Item parents must be empty after Collection::clean()'
        );
        self::assertTrue(
            $child2->getParent() === null,
            'Item parents must be empty after Collection::clean()'
        );

    }
}
