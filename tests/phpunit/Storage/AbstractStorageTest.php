<?php

namespace ViewComponents\ViewComponents\Test\Storage;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;
use ViewComponents\ViewComponents\Storage\KeyValueStorageInterface;

abstract class AbstractStorageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var KeyValueStorageInterface
     */
    protected $storage;

    public function test()
    {
        $this->assertFalse($this->storage->has('non-existing key'));
        $this->storage->set('1', 'test');
        $this->assertTrue($this->storage->has('1'));
        $this->assertEquals('test', $this->storage->get('1'));
        $ex = null;
        try{
            $this->storage->get('non-existing key');
        } catch(\InvalidArgumentException $e) {
            $ex = $e;
        }
        $this->assertInstanceOf(InvalidArgumentException::class, $ex);

        $this->storage->delete('1');
        $this->assertFalse($this->storage->has('1'));

        $ex = null;
        try{
            $this->storage->delete('non-existing key');
        } catch(\InvalidArgumentException $e) {
            $ex = $e;
        }
        $this->assertInstanceOf(InvalidArgumentException::class, $ex);
    }
}