<?php

namespace ViewComponents\ViewComponents\Test\Service;

use PHPUnit_Framework_TestCase;
use ViewComponents\ViewComponents\Service\ServiceContainer;

class ServiceContainerTest extends PHPUnit_Framework_TestCase
{
    /** @var  ServiceContainer */
    private $container;

    public function setUp()
    {
        $this->container = new ServiceContainer();
        $this->container->set('existing_item', function () {
            return new \stdClass();
        });
    }

    public function testSame()
    {
        $counter = 0;
        $instance = null;
        $this->container->set('item', function () use (&$counter, &$instance) {
            $instance = new \stdClass();
            $counter++;
            return $instance;
        });
        $first = $this->container->get('item');
        $second = $this->container->get('item');
        self::assertTrue($first === $second);
        self::assertTrue($first === $instance);
        self::assertTrue($counter === 1);
    }

    public function testNoItem()
    {
        self::assertFalse($this->container->has('item'));
    }

    public function testExistingItem()
    {
        self::assertTrue($this->container->has('existing_item'));
    }

    public function testNoEarlyInstantiating()
    {
        $ready = false;
        $this->container->set('item', function()use (&$ready){
            $ready = true;
            return new \stdClass();
        });
        $this->assertFalse($ready);
        $this->container->get('item');
        $this->assertTrue($ready);
    }

    public function testNoEarlyInstantiatingWhenExtending()
    {
        $counter = 0;
        $counter2 = 0;
        $oldInstance = null;
        $newInstance = null;
        $this->container->set('item', function()use (&$counter, &$oldInstance){
            $counter++;
            $oldInstance = new \stdClass();
            return $oldInstance;
        });
        $this->assertEquals(0, $counter);
        $this->container->extend('item', function($item) use (&$counter2, &$newInstance) {
            $counter2++;
            $newInstance = new \stdClass();
            return $newInstance;
        });
        $this->assertEquals(0, $counter);
        $this->assertEquals(0, $counter2);
        $this->assertEquals(null, $oldInstance);
        $this->assertEquals(null, $newInstance);

        self::assertTrue($this->container->get('item') !== null);
        self::assertTrue($this->container->get('item') === $newInstance);
        self::assertTrue($newInstance !== $oldInstance);
        $this->assertEquals(1, $counter);
        $this->assertEquals(1, $counter2);
    }

}
