<?php

namespace Presentation\Framework\Common;

use Nayjest\Tree\Tree;
use Presentation\Framework\Base\ComponentInterface;

trait TreeAggregate
{
    /**
     * @var Tree
     */
    private $tree;

    /**
     * @return Tree
     */
    public function getTree()
    {
        return $this->tree;
    }

    public function appendComponent($parentName = null, $componentName, ComponentInterface $component = null)
    {
        if ($componentName instanceof ComponentInterface) {
            $component = $componentName;
            $componentName = $component->getComponentName();
        }
        $this->getTree()->append($parentName, $componentName, $component);
        return $this;
    }

    public function prependComponent($parentName = null, $componentName, ComponentInterface $component = null)
    {
        if ($componentName instanceof ComponentInterface) {
            $component = $componentName;
            $componentName = $component->getComponentName();
        }
        $this->getTree()->prepend($parentName, $componentName, $component);
        return $this;
    }

    public function setComponent($name, ComponentInterface $component = null)
    {
        $this->getTree()->replace($name, $component);
        return $this;
    }

    public function hasComponent($componentName)
    {
        return $this->getTree()->has($componentName);
    }


    public function getComponent($componentName)
    {
        return $this->getTree()->get($componentName);
    }

    /**
     * @param $parentName
     * @param ComponentInterface[] $namedComponents
     * @param bool|false $prepend
     * @return $this
     */
    public function addComponents($parentName, array $namedComponents, $prepend = false)
    {
        $prepared = [];
        foreach ($namedComponents as $key => $value) {
            $prepared[is_int($key) ? $value->getComponentName() : $key] = $value;
        }
        $this->getTree()->addMany($parentName, $prepared, $prepend);
        return $this;
    }

    public function removeComponent($componentName)
    {
        $this->getTree()->remove($componentName);
    }

    public function moveComponent($componentName, $newParentName, $prepend = false)
    {
        $this->getTree()->move($componentName, $newParentName, $prepend);
    }

}