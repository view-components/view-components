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

    /** @var string[] */
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
     * @param string $serviceProviderClass
     */
    public static function registerServiceProvider($serviceProviderClass)
    {
        if (!is_a($serviceProviderClass, ServiceProviderInterface::class, true)) {
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

    private static function provideServices()
    {
        foreach(self::$serviceProviders as $serviceProviderClass) {
            /** @var  ServiceProviderInterface $serviceProvider */
            $serviceProvider = new $serviceProviderClass;
            $serviceProvider->register(self::$container);
        }
    }
}
