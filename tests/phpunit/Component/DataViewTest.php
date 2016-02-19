<?php
namespace ViewComponents\ViewComponents\Test\Component;

use PHPUnit_Framework_TestCase;
use ViewComponents\ViewComponents\Component\DataView;

class DataViewTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $text = new DataView('some text');
        self::assertEquals('some text', $text->render());
        self::assertEquals('some text', $text->getData());
        $res = $text->setData('some text 2');
        self::assertEquals($text, $res);
        self::assertEquals('some text 2', $text->render());
    }
}
