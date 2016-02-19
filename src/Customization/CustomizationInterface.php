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
     * Applies customizations to component & its children.
     *
     * @param ComponentInterface $component
     * @return mixed
     */
    public function apply(ComponentInterface $component);
}
