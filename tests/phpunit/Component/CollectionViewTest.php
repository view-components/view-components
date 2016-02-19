<?php
namespace ViewComponents\ViewComponents\Test\Component;

use ViewComponents\ViewComponents\Component\CollectionView;
use ViewComponents\ViewComponents\Component\Container;
use ViewComponents\ViewComponents\Component\DataView;

use PHPUnit_Framework_TestCase;

class CollectionViewTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $repeater = new CollectionView(
            [
                1,
                2,
                3,
            ],
            [new DataView()]
        );
        self::assertEquals('123', $repeater->render());
    }

    public function testWithMultipleComponents()
    {
        $repeater = new CollectionView(
            [
                1,
                2,
            ],
            [new DataView, new DataView]
        );
        self::assertEquals('1122', $repeater->render());
    }
    public function testWithContainer()
    {
        $repeater = new CollectionView(
            [
                1,
                2,
            ],
            [
                new Container([
                    new DataView('[')
                ]),
                new DataView,
                new Container([
                    new DataView(']')
                ])
            ]
        );
        self::assertEquals('[1][2]', $repeater->render());
    }
}
