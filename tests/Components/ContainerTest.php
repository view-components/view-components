<?php
namespace Nayjest\ViewComponents\Test\Components;

use Nayjest\ViewComponents\Components\Container;
use Nayjest\ViewComponents\Components\Text;
use Nayjest\ViewComponents\Test\Mock\ChildClass;
use Nayjest\ViewComponents\Test\Mock\HierarchyItem;
use Nayjest\ViewComponents\Test\Mock\ParentClass;
use PHPUnit_Framework_TestCase;

class ContainerTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $c = new Container();
        $c->setOpeningText('[')
            ->setClosingText(']');
        self::assertEquals('[]', $c->render());

        $t = new Text('inner');
        $c->setComponents([$t]);
        self::assertEquals('[inner]', $c->render());

        $c2 = new Container();
        $c2->setOpeningText('{')
            ->setClosingText('}');
        $c->components()->add($c2);
        $c2->setComponents([$t, $t]);
        self::assertEquals('[{inner}]', $c->render());
    }

    public function testNotRenderableComponents()
    {
        // Renderable container can store not renderable items.
        $container = new Container([
            new ChildClass,
            new Text('test')
        ]);
        self::assertEquals(
            'test',
            $container->render()
        );

        // Renderable store not renderable that store renderable
        $container->setComponents([
            new Text('ok'),
            (new HierarchyItem)
                ->setComponents([new Text('Must not be rendered')])
        ]);
        self::assertEquals(
            'ok',
            $container->render()
        );
    }
}
