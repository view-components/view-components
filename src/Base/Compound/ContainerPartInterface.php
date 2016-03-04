<?php

namespace ViewComponents\ViewComponents\Base\Compound;

use ViewComponents\ViewComponents\Base\ContainerComponentInterface;

/**
 * Interface for compound parts that can be used as parent for another compound parts.
 *
 */
interface ContainerPartInterface extends ContainerComponentInterface, PartInterface
{
    /**
     * @return ContainerComponentInterface
     */
    public function getContainer();
}
