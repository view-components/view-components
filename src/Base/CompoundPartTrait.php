<?php

namespace Presentation\Framework\Base;

use Presentation\Framework\Component\CompoundComponent;

trait CompoundPartTrait
{
    protected $root;

    /**
     * @param CompoundComponent $root
     * @return string|null
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