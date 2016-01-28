<?php

namespace Presentation\Framework\Service;

use Presentation\Framework\Service\Container\Adapter\Pimple3ContainerAdapter;
use Presentation\Framework\Service\Container\Adapter\PimpleContainerAdapter;
use Presentation\Framework\Service\Container\Container;
use Presentation\Framework\Service\Container\WritableContainerInterface;
use Presentation\Framework\Service\Exception\BootstrapException;

/**
 * Bootstrapping of presentation framework DI.
 *
 * This class is used internally by presentation framework
 * if dependency injection facilities is utilised.
 *
 * It also provides facilities for integration with 3r-party packages & frameworks.
 *
 */
final class Bootstrap
{
    /** @var  null|WritableContainerInterface */
    private static $container;

    /**
     * Keys are container class names and values are container adapter class names.
     *
     * @var string[]
     */
    private static $supportedAdapters = [
        '\Pimple\Container' => Pimple3ContainerAdapter::class,
        '\Pimple\Pimple'    => PimpleContainerAdapter::class,
    ];

    /** @var string[] */
    private static $serviceProviders = [
        ServiceProvider::class
    ];

    /** @var  object|string */
    private static $preferredContainer = Container::class;

    /**
     * Returns service container used with presentation framework.
     *
     * @return WritableContainerInterface
     */
    public static function getContainer()
    {
        if (!self::$container) {
            self::initializeContainer();
        }
        return self::$container;
    }

    /**
     * Registers adapter class for 3rd-party service container class.
     *
     * @param string $containerClass
     * @param string $adapterClass
     */
    public static function registerContainerAdapter($containerClass, $adapterClass)
    {
        self::$supportedAdapters[$containerClass] = $adapterClass;
    }

    /**
     * Registers service provider.
     *
     * This method can be used before or after service container initialization.
     *
     * @param string $serviceProviderClass
     */
    public static function registerServiceProvider($serviceProviderClass)
    {
        if (!is_a($serviceProviderClass, ServiceProviderInterface::class)) {
            throw new BootstrapException(
                "Error registering service provider: $serviceProviderClass is not valid service provider."
            );
        }
        if (self::$container === null) {
            self::$serviceProviders[] = $serviceProviderClass;
        } else {
            /** @var ServiceProviderInterface $provider */
            $provider = new $serviceProviderClass;
            $provider->register(self::$container);
        }
    }

    /**
     * Specifies service container to use.
     *
     * It's possible to use service container of application that uses presentation framework.
     * In this case services of presentation framework will be shared to application using its own service container.
     *
     *
     * @param string|object $container container instance or class name (do not use adapter class names here).
     */
    public static function useContainer($container)
    {
        self::checkNoContainer();
        self::$preferredContainer = $container;
    }

    /**
     * Initializes service container.
     *
     * @return WritableContainerInterface
     */
    private static function initializeContainer()
    {
        $isInstance = !is_string(self::$preferredContainer);
        $origClass = $isInstance ? get_class(self::$preferredContainer) : self::$preferredContainer;
        $containerInstance = $isInstance ? self::$preferredContainer : new $origClass;

        // Try create service container adapter
        if (!$containerInstance instanceof WritableContainerInterface) {
            if (!array_key_exists($origClass, self::$supportedAdapters)) {
                throw new BootstrapException(
                    "Can't use '$origClass' container, there is no supported adapters for this container."
                );
            }
            $adapterClass = self::$supportedAdapters[$origClass];
            $containerInstance = new $adapterClass($containerInstance);
        }

        self::$container = $containerInstance;
        self::provideServices();
    }

    private static function provideServices()
    {
        foreach(self::$serviceProviders as $serviceProviderClass) {
            /** @var  ServiceProviderInterface $serviceProvider */
            $serviceProvider = new $serviceProviderClass;
            $serviceProvider->register(self::$container);
        }
    }

    /**
     * Checks that service container is not initialized. Throws exception otherwise.
     *
     * @throws BootstrapException
     */
    private static function checkNoContainer()
    {
        if (self::$container !== null) {
            throw new BootstrapException(
                'Trying to configure service container when it\'s already created.'
            );
        }
    }
}
