<?php
namespace Nayjest\ViewComponents\Test\Components;

use Nayjest\ViewComponents\Components\Container;
use Nayjest\ViewComponents\Components\Text;
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
}
