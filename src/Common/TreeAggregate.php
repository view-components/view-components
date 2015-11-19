<?php

namespace Presentation\Framework\Common;

use Nayjest\Tree\Tree;
use Presentation\Framework\Base\ComponentInterface;

trait TreeAggregate
{
    /**
     * @var Tree
     */
    protected $tree;

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
        $this->tree->append($parentName, $componentName, $component);
        return $this;
    }

    public function prependComponent($parentName = null, $componentName, ComponentInterface $component = null)
    {
        if ($componentName instanceof ComponentInterface) {
            $component = $componentName;
            $componentName = $component->getComponentName();
        }
        $this->tree->prepend($parentName, $componentName, $component);
        return $this;
    }

    public function setComponent($name, ComponentInterface $component = null)
    {
        $this->tree->replace($name, $component);
        return $this;
    }

    public function hasComponent($componentName)
    {
        return $this->tree->has($componentName);
    }


    public function getComponent($componentName)
    {
        return $this->tree->get($componentName);
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
        $this->tree->addMany($parentName, $prepared, $prepend);
        return $this;
    }

    public function removeComponent($componentName)
    {
        $this->tree->remove($componentName);
    }

}