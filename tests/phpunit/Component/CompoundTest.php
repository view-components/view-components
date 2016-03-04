<?php

namespace ViewComponents\ViewComponents\Test\Component;

use PHPUnit_Framework_TestCase;
use ViewComponents\ViewComponents\Component\Compound;
use ViewComponents\ViewComponents\Component\DataView;
use ViewComponents\ViewComponents\Component\Html\Tag;
use ViewComponents\ViewComponents\Component\Part;

class CompoundTest extends PHPUnit_Framework_TestCase
{
    public function testEmpty()
    {
        $c = new Compound([]);
        self::assertTrue($c->render() === '');
    }

    public function testComponentsInConstructor()
    {
        $c = new Compound(
            [
                new Part(new Tag('div'), 'container'),
                new Part(new DataView('[1]'), '1', 'container'),
                new Part(new DataView('[2]'), '2', 'container'),
            ]
        );
        self::assertEquals(
            '<div>[1][2]</div>',
            $c->render()
        );
    }

    public function testComponentSet()
    {
        $c = new Compound(
            [
                new Part(new Tag('div'), 'container'),
                new Part(new DataView('[1]'), '1', 'container'),
                new Part(new DataView('[2]'), '2', 'container'),
            ]
        );
        $c->setComponent($c3 = new DataView('[3]'), '3', 'container');
        self::assertEquals(
            '<div>[1][2][3]</div>',
            $c->render()
        );
        // @todo preserve component position when replacing
//        $c->setComponent($c2 = new DataView('[-2-]'), '2', 'container');
//        self::assertEquals(
//            '<div>[1][-2-][3]</div>',
//            $c->render()
//        );
//        self::assertTrue($c2 === $c->getComponent('2'));
        self::assertTrue($c3 === $c->getComponent('3'));

        $c->removeComponent('1');
        $c->removeComponent('2');
        self::assertEquals(
            '<div>[3]</div>',
            $c->render()
        );
        $c->removeComponent('container');
        self::assertEquals(
            '',
            $c->render()
        );
    }
}