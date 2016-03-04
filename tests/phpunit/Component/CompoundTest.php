<?php

namespace ViewComponents\ViewComponents\Test\Component;

use PHPUnit_Framework_TestCase;
use ViewComponents\ViewComponents\Component\Compound;

class CompoundTest extends PHPUnit_Framework_TestCase
{
    public function testEmpty()
    {
        $c = new Compound([]);
        self::assertTrue($c->render() === '');
    }
}