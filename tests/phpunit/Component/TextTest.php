<?php
namespace Presentation\Framework\Test\Component;

use Presentation\Framework\Component\Text;
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

        $text->children()->add(new Text(function(){return '!';}));
        self::assertEquals('some text 2!', $text->render());

    }
}
