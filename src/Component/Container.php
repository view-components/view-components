<?php

namespace ViewComponents\ViewComponents\Component;

use ViewComponents\ViewComponents\Base\ContainerComponentInterface;
use ViewComponents\ViewComponents\Base\ContainerComponentTrait;

/**
 * The Container component stores and renders its children.
 *
 */
class Container implements ContainerComponentInterface
{
    use ContainerComponentTrait;

    /**
     * Container constructor.
     *
     * @param array|null $components
     */
    public function __construct(array $components = null)
    {
        $this->initializeCollection($components ?: []);
    }

    /**
     * Renders component.
     *
     * @return string
     */
    public function render()
    {
        return $this->renderChildren();
    }
}
