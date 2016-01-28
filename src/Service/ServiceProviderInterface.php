<?php

namespace Presentation\Framework\Service;

use Presentation\Framework\Service\Container\WritableContainerInterface;

/**
 * Service provider interface.
 */
interface ServiceProviderInterface
{
    /**
     * Registers services on the given container.
     *
     * @param WritableContainerInterface $container container instance
     */
    public function register(WritableContainerInterface $container);
}
