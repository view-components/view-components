<?php
namespace ViewComponents\ViewComponents\Test\Component;

use ViewComponents\ViewComponents\Component\Container;

use PHPUnit_Framework_TestCase;
use ViewComponents\ViewComponents\Component\DataView;

class ContainerTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $container = new Container();
        $c1 = new DataView('1');
        $c2 = new DataView('2');
        $container->children()->set([$c1,$c2]);
        self::assertEquals('12', $container->render());
    }
}
