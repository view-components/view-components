<?php
namespace Presentation\Framework\Test\Components\Html;


use Presentation\Framework\Components\Html\A;
use Presentation\Framework\Components\Text;
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