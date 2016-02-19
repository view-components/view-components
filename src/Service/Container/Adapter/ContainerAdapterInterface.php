<?php

namespace ViewComponents\ViewComponents\Service\Container\Adapter;

use Interop\Container\ContainerInterface;

interface ContainerAdapterInterface extends ContainerInterface
{
    public function __construct($container);

    public function getContainer();
}