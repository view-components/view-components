<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.04.2015
 * Time: 20:11
 */

namespace Nayjest\ViewComponents\Test\Components;


use Nayjest\ViewComponents\Components\HtmlTag;
use Nayjest\ViewComponents\Components\Text;
use PHPUnit_Framework_TestCase;

class HtmlTagTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $tag = new HtmlTag();
        $this->assertEquals('<div></div>', $tag->render());

        $tag->setTagName('a');
        $this->assertEquals('<a></a>', $tag->render());

        $tag->setAttributes([
           'class' => 'btn'
        ]);
        $this->assertEquals('<a class="btn"></a>', $tag->render());

        $first = new HtmlTag();
        $first
            ->setTagName('i')
            ->setAttributes(['class' => 'icon']);
        $first->components()->add(new Text('&nbsp;'));
        $second = new Text('Hi!');
        $tag->components()->set([$first, $second]);
        $this->assertEquals(
            '<a class="btn"><i class="icon">&nbsp;</i>Hi!</a>',
            $tag->render()
        );
    }
}