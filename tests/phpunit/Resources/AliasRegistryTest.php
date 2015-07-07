<?php
namespace Presentation\Framework\Test\Resources;


use Presentation\Framework\Resources\AliasRegistry;
use PHPUnit_Framework_TestCase;

class AliasRegistryTest extends PHPUnit_Framework_TestCase
{

    public function test()
    {
        $url = 'http://somewhere.com/jquery2.js';
        $registry = new AliasRegistry([
            'jquery' => $url
        ]);
        self::assertEquals($url, $registry->get('jquery'));
        self::assertEquals(null, $registry->get('jquery2'));
        self::assertEquals('/jquery.js', $registry->get('jquery2','/jquery.js'));
    }
}
