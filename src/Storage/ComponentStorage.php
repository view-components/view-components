<?php

namespace ViewComponents\ViewComponents\Storage;

use ViewComponents\ViewComponents\Base\ComponentInterface;

class ComponentStorage extends ObjectStorage
{
    /**
     * @param string $key
     * @param ComponentInterface $value
     * @return $this
     */
    public function set($key, $value)
    {
        $parent = $value->parent();
        $parent && $value->internalUnsetParent();
        parent::set($key, $value);
        $parent && $value->internalSetParent($parent);
        return $this;
    }

    /**
     * @param string $key
     * @return ComponentInterface|null
     */
    public function get($key)
    {
        return parent::get($key);
    }
}
