<?php
namespace Presentation\Framework\Test\Component;

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
        $c->children()->set([$t]);
        self::assertEquals('[inner]', $c->render());

        $c2 = new Container();
        $c2->setOpeningText('{')
            ->setClosingText('}');
        $c->children()->add($c2);
        $c2->children()->set([$t, $t]);
        self::assertEquals('[{inner}]', $c->render());
    }
}
