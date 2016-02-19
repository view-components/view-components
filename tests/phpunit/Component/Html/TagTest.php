<?php

namespace ViewComponents\ViewComponents\Test\Component\Html;

use ViewComponents\ViewComponents\Component\DataView;
use ViewComponents\ViewComponents\Component\Html\Tag;
use ViewComponents\ViewComponents\Component\Text;
use PHPUnit_Framework_TestCase;

class TagTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $tag = new Tag();
        $this->assertEquals('<div></div>', $tag->render());

        $tag->setTagName('a');
        $this->assertEquals('<a></a>', $tag->render());

        $tag->setAttributes([
            'class' => 'btn'
        ]);
        $this->assertEquals('<a class="btn"></a>', $tag->render());

        $first = new Tag();
        $first
            ->setTagName('i')
            ->setAttributes(['class' => 'icon']);
        $first->children()->add(new DataView('&nbsp;'));
        $second = new DataView('Hi!');
        $tag->children()->set([$first, $second]);
        $this->assertEquals(
            '<a class="btn"><i class="icon">&nbsp;</i>Hi!</a>',
            $tag->render()
        );
    }
}
