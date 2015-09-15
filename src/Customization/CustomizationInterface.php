<?php

namespace Presentation\Framework\Customization;

use Presentation\Framework\Base\ComponentInterface;

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
