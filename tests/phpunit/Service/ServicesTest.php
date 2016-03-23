<?php

namespace ViewComponents\ViewComponents\Test\Service;

use Interop\Container\ContainerInterface;
use PHPUnit_Framework_TestCase;
use ViewComponents\ViewComponents\Rendering\RendererInterface;
use ViewComponents\ViewComponents\Resource\ResourceManager;
use ViewComponents\ViewComponents\Service\ServiceId;
use ViewComponents\ViewComponents\Service\Services;

class ServicesTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        self::assertInstanceOf(ContainerInterface::class, Services::container());
        self::assertTrue(is_array(Services::container()->get(ServiceId::CONFIG)));
        self::assertInstanceOf(RendererInterface::class, Services::renderer());
        self::assertInstanceOf(ResourceManager::class, Services::resourceManager());
    }
}
