<?php

namespace ViewComponents\ViewComponents\Service;

use Interop\Container\ContainerInterface;
use ViewComponents\ViewComponents\HtmlBuilder;
use ViewComponents\ViewComponents\Rendering\RendererInterface;
use ViewComponents\ViewComponents\Resource\ResourceManager;

/**
 * Facade for accessing services.
 */
class Services
{
    /** @var  ContainerInterface */
    protected static $container;

    /**
     * @return ContainerInterface
     */
    public static function container()
    {
        if (!self::$container) {
            self::$container = Bootstrap::getContainer();
        }
        return self::$container;
    }

    /**
     * @param string $serviceId
     * @return mixed
     */
    public static function get($serviceId)
    {
        return self::container()->get($serviceId);
    }

    /**
     * @return HtmlBuilder
     */
    public static function htmlBuilder()
    {
        return self::get(ServiceName::HTML_BUILDER);
    }

    /**
     * @return ResourceManager
     */
    public static function resourceManager()
    {
        return self::get(ServiceName::RESOURCE_MANAGER);
    }

    /**
     * @return RendererInterface;
     */
    public static function renderer()
    {
        return self::get(ServiceName::RENDERER);
    }
}
