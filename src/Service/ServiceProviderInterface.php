<?php

namespace ViewComponents\ViewComponents\Service;

/**
 * Service provider interface.
 */
interface ServiceProviderInterface
{
    /**
     * Registers services on the given container.
     *
     * @param Container $container container instance
     */
    public function register(Container $container);
}
