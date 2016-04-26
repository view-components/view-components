<?php

namespace ViewComponents\ViewComponents\Service;

use Interop\Container\ContainerInterface;
use ViewComponents\ViewComponents\HtmlBuilder;
use ViewComponents\ViewComponents\Rendering\RendererInterface;
use ViewComponents\ViewComponents\Rendering\TemplateFinder;
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
        return self::get(ServiceId::HTML_BUILDER);
    }

    /**
     * @return ResourceManager
     */
    public static function resourceManager()
    {
        return self::get(ServiceId::RESOURCE_MANAGER);
    }

    /**
     * @return RendererInterface;
     */
    public static function renderer()
    {
        return self::get(ServiceId::RENDERER);
    }

    /**
     * @return TemplateFinder;
     */
    public static function templateFinder()
    {
        return self::get(ServiceId::TEMPLATE_FINDER);
    }
}
