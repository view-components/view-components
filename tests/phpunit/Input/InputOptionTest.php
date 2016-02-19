<?php
namespace ViewComponents\ViewComponents\Test\Input;


use PHPUnit_Framework_TestCase;
use ViewComponents\ViewComponents\Input\InputOption;

class InputOptionTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        // existing value in input + default
        $a = new InputOption('a', ['a'=>'A', 'e'=>'E'], 'default');
        self::assertEquals('a', $a->getKey());
        self::assertEquals('A', $a->getValue());
        self::assertEquals('A', $a->getInputValue());
        self::assertEquals('default', $a->getDefaultValue());
        self::assertEquals(true, $a->hasValue());

        // no value in input + default
        $b = new InputOption('b', ['a'=>'A', 'e'=>'E'], 'default');
        self::assertEquals('default', $b->getValue());
        self::assertEquals(null, $b->getInputValue());
        self::assertEquals('default', $b->getDefaultValue());
        self::assertEquals(true, $b->hasValue());

        // no value in input + no default
        $c = new InputOption('c', ['a'=>'A', 'e'=>'E']);
        self::assertEquals(false, $c->hasValue());

        // existing value in input + no default
        $e = new InputOption('e', ['a'=>'A', 'e'=>'E']);
        self::assertEquals(true, $e->hasValue());
        self::assertEquals(null, $e->getDefaultValue());
    }
}
