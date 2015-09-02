<?php

namespace Presentation\Framework\Test\Component\Html;

use Presentation\Framework\Component\Html\Tag;
use Presentation\Framework\Component\Text;
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
        $first->children()->add(new Text('&nbsp;'));
        $second = new Text('Hi!');
        $tag->children()->set([$first, $second]);
        $this->assertEquals(
            '<a class="btn"><i class="icon">&nbsp;</i>Hi!</a>',
            $tag->render()
        );
    }
}
