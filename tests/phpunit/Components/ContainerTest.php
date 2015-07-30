<?php
namespace Presentation\Framework\Test\Components;

use Presentation\Framework\Component\Container;
use Presentation\Framework\Component\Text;
use Presentation\Framework\Rendering\ViewInterface;
use Presentation\Framework\Test\Mock\ChildClass;
use Presentation\Framework\Test\Mock\HierarchyItem;
use Presentation\Framework\Test\Mock\ParentClass;
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
        $c->children()->setItems([$t]);
        self::assertEquals('[inner]', $c->render());

        $c2 = new Container();
        $c2->setOpeningText('{')
            ->setClosingText('}');
        $c->children()->addItem($c2);
        $c2->children()->setItems([$t, $t]);
        self::assertEquals('[{inner}]', $c->render());
    }
}
