<?php
namespace Nayjest\ViewComponents\Test\Components\Html;


use Nayjest\ViewComponents\Components\Html\A;
use Nayjest\ViewComponents\Components\Text;
use PHPUnit_Framework_TestCase;

class ATest extends PHPUnit_Framework_TestCase
{

    public function test()
    {
        $a = new A(['href' => '#'], [new Text('Link')]);
        self::assertEquals('<a href="#">Link</a>', $a->render());

        $a2 = new A;
        self::assertEquals('<a></a>', $a2->render());
    }
}