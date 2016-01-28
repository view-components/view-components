<?php

namespace Presentation\Framework\Test\Resource;

use Interop\Container\ContainerInterface;
use PHPUnit_Framework_TestCase;
use Presentation\Framework\Rendering\RendererInterface;
use Presentation\Framework\Resource\ResourceManager;
use Presentation\Framework\Service\ServiceName;
use Presentation\Framework\Service\Services;

class ServicesTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        self::assertInstanceOf(ContainerInterface::class, Services::container());
        self::assertTrue(is_array(Services::container()->get(ServiceName::CONFIG)));
        self::assertInstanceOf(RendererInterface::class, Services::renderer());
        self::assertInstanceOf(ResourceManager::class, Services::resourceManager());
    }
}
