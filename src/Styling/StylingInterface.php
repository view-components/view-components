<?php

namespace Presentation\Framework\Styling;

use Presentation\Framework\Base\ComponentInterface;

/**
 * Interface StylingInterface.
 *
 */
interface StylingInterface
{
    /**
     * Applies customizations to component & its children.
     *
     * @param ComponentInterface $component
     * @return mixed
     */
    public function apply(ComponentInterface $component);
}
