<?php
namespace ViewComponents\ViewComponents\Test\Resource;

use ViewComponents\ViewComponents\Resource\AliasRegistry;
use PHPUnit_Framework_TestCase;

class AliasRegistryTest extends PHPUnit_Framework_TestCase
{

    public function test()
    {
        $url = 'http://somewhere.com/jquery2.js';
        $registry = new AliasRegistry([
            'jquery' => $url
        ]);

        // test get()
        self::assertEquals($url, $registry->get('jquery'));
        self::assertEquals(null, $registry->get('jquery2'));
        self::assertEquals('/jquery.js', $registry->get('jquery2','/jquery.js'));

        // test has()
        self::assertTrue($registry->has('jquery'));
        self::assertFalse($registry->has('jquery2'));

        // test set(), existing alias, do not overwrite
        self::assertFalse($registry->set('jquery', 'new url'));
        self::assertEquals($url, $registry->get('jquery'));

        // test set() existing alias, overwrite
        self::assertTrue($registry->set('jquery', 'new url', true));
        self::assertEquals('new url', $registry->get('jquery'));

        // test set() new alias
        self::assertTrue($registry->set('jquery2', 'new resource'));
        self::assertEquals('new resource', $registry->get('jquery2'));
    }
}
