<?php

namespace ViewComponents\ViewComponents\Base\Compound;

use ViewComponents\ViewComponents\Base\ContainerComponentInterface;
use ViewComponents\ViewComponents\Base\ViewComponentInterface;
use ViewComponents\ViewComponents\Component\Compound;

/**
 * Interface for compound parts that knows where it must be placed inside compound.
 */
interface CompoundPartInterface extends ContainerComponentInterface
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

    /**
     * @return ContainerComponentInterface
     */
    public function getInnerContainer();

    /** @return ViewComponentInterface */
    public function getView();

    public function attachToCompound(Compound $root);
}