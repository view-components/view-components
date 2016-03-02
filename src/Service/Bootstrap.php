<?php

namespace ViewComponents\ViewComponents\Service;

use ViewComponents\ViewComponents\Service\Exception\BootstrapException;

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
    /** @var  null|ServiceContainer */
    private static $container;

    /** @var string[]|ServiceProviderInterface[] */
    private static $serviceProviders = [
        CoreServiceProvider::class
    ];

    /**
     * Returns service container used with presentation framework.
     *
     * @return ServiceContainer
     */
    public static function getContainer()
    {
        if (!self::$container) {
            self::$container = new ServiceContainer();
            self::provideServices();
        }
        return self::$container;
    }

    /**
     * Registers service provider.
     *
     * This method can be used before or after service container initialization.
     *
     * @param string|callable $serviceProvider service provider class or callable
     */
    public static function registerServiceProvider($serviceProvider)
    {
        if (is_callable($serviceProvider)) {
            $serviceProvider = new CustomServiceProvider($serviceProvider);
        } elseif (!is_a($serviceProvider, ServiceProviderInterface::class, true)) {
            throw new BootstrapException(
                "Error registering service provider: $serviceProvider is not valid service provider."
            );
        }
        if (self::$container === null) {
            self::$serviceProviders[] = $serviceProvider;
        } else {
            /** @var ServiceProviderInterface $provider */
            $provider = new $serviceProvider;
            $provider->register(self::$container);
        }
    }

    private static function provideServices()
    {
        foreach (self::$serviceProviders as $serviceProviderSrc) {
            /** @var  ServiceProviderInterface $serviceProvider */
            $serviceProvider = $serviceProviderSrc instanceof ServiceProviderInterface
                ? $serviceProviderSrc
                : new $serviceProviderSrc;
            $serviceProvider->register(self::$container);
        }
    }
}
