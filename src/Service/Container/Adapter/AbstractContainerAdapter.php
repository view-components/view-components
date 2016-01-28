<?php

namespace Presentation\Framework\Service\Container\Adapter;


abstract class AbstractContainerAdapter implements ContainerAdapterInterface
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getContainer()
    {
        return $this->container;
    }

}
