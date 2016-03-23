<?php

namespace ViewComponents\ViewComponents\Base\Compound;

use ViewComponents\ViewComponents\Base\ComponentInterface;
use ViewComponents\ViewComponents\Base\ContainerComponentInterface;
use ViewComponents\ViewComponents\Component\Compound;

/**
 * Interface for compound parts.
 * Compound parts are components that knows
 * where they must be placed inside compound.
 */
interface PartInterface extends ComponentInterface
{
    /**
     * Method must return name of tree node that should be chosen as parent.
     * It's used when attaching CompoundPart to Compound directly (not to tree).
     *
     * If component must not be placed to tree (just placed to children), return false
     * If component must be placed to tree as child of root node, return null
     *
     * @param Compound|null $root
     *
     * @return string|false|null
     */
    public function getDestinationParentId(Compound $root = null);

    /**
     * Returns id that must be unique inside compound root.
     *
     * @return string
     */
    public function getId();

    public function setId($id);

    /**
     * @param $id
     * @return string
     */
    public function setDestinationParentId($id);

    /**
     * @return ContainerComponentInterface
     */

    /**
     * @param Compound $root
     */
    public function attachToCompound(Compound $root);

    /**
     * @return Compound|null
     */
    public function getRoot();

    /**
     * @return bool
     */
    public function isAttached();
}
