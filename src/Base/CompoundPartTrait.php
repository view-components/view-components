<?php

namespace Presentation\Framework\Base;

use Presentation\Framework\Component\CompoundComponent;

trait CompoundPartTrait
{
    protected $root;

    /**
     * Method must return name of tree node that should be chosen as parent.
     * It's used when attaching CompoundPart to CompoundComponent directly (not to tree).
     *
     * If component must not be placed to tree (just placed to children), return false
     * If component must be placed to tree as child of root node, return null
     *
     * @param CompoundComponent $root
     * @return string|false|null
     */
    abstract public function resolveParentName(CompoundComponent $root);

    /**
     * @return CompoundComponent
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * @internal
     * @param CompoundComponent $root
     */
    public function setRootInternal(CompoundComponent $root)
    {
        $this->root = $root;
    }
}