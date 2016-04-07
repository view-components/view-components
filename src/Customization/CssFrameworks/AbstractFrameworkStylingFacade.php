<?php

namespace ViewComponents\ViewComponents\Customization\CssFrameworks;

use ViewComponents\ViewComponents\Base\ComponentInterface;
use ViewComponents\ViewComponents\Customization\Configurable\Customization;
use ViewComponents\ViewComponents\Resource\ResourceManager;
use ViewComponents\ViewComponents\Service\Services;

abstract class AbstractFrameworkStylingFacade extends Customization
{
    const STYLING_CONFIG_SERVICE_ID = null;

    /**
     * Applies customization to target component and its children.
     *
     * @param ComponentInterface $component
     */
    public static function applyTo(ComponentInterface $component)
    {
        $inst = new static;
        $inst->apply($component);
    }

    /**
     * Constructor.
     *
     * @param ResourceManager|null $resourceManager
     */
    public function __construct(ResourceManager $resourceManager = null)
    {
        parent::__construct(
            Services::get(static::STYLING_CONFIG_SERVICE_ID),
            $resourceManager
        );
    }
}
