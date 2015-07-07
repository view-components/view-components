<?php
namespace Presentation\Framework\Test\Components;

use Presentation\Framework\Components\Text;
use PHPUnit_Framework_TestCase;

class TextTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $text = new Text('some text');
        self::assertEquals('some text', $text->render());
        self::assertEquals('some text', $text->getValue());
        $res = $text->setValue('some text 2');
        self::assertEquals($text, $res);
        self::assertEquals('some text 2', $text->render());
    }
}
