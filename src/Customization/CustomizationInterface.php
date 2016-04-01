<?php

namespace ViewComponents\ViewComponents\Customization;

use ViewComponents\ViewComponents\Base\ComponentInterface;

/**
 * Interface CustomizationInterface.
 *
 */
interface CustomizationInterface
{
    /**
     * Applies customizations to target component and its children.
     *
     * @param ComponentInterface $component
     */
    public function apply(ComponentInterface $component);
}
