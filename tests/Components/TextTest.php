<?php
namespace Nayjest\ViewComponents\Test\Components;

use Nayjest\ViewComponents\Components\Text;
use PHPUnit_Framework_TestCase;

class TextTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $text = new Text('some text');
        $this->assertEquals('some text', $text->render());
        $text->setValue('some text 2');
        $this->assertEquals('some text 2', $text->render());
    }
}