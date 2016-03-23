<?php

namespace ViewComponents\ViewComponents\Customization\CssFrameworks;

use ViewComponents\ViewComponents\Base\ComponentInterface;
use ViewComponents\ViewComponents\Customization\Configurable\Customization;
use ViewComponents\ViewComponents\Resource\ResourceManager;
use ViewComponents\ViewComponents\Service\Services;

abstract class AbstractFrameworkStylingFacade extends Customization
{
    const CONFIG_SERVICE_ID = null;

    public static function applyTo(ComponentInterface $component)
    {
        $inst = new static;
        $inst->apply($component);
    }

    public function __construct(ResourceManager $resourceManager = null)
    {
        parent::__construct(Services::get(static::CONFIG_SERVICE_ID), $resourceManager);
    }
}
