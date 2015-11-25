<?php

namespace Presentation\Framework\Common;

use Nayjest\Tree\Exception\NodeNotFoundException;
use Nayjest\Tree\NodeCollection;
use Presentation\Framework\Base\ComponentInterface;
use Presentation\Framework\Base\CompoundPartInterface;
use Presentation\Framework\Component\CompoundComponent;

class CompoundPartCollection extends NodeCollection
{
    /**
     * @return CompoundComponent
     */
    private function getCompoundRoot()
    {
        return $this->parentNode;
    }

    /**
     * @param $component
     * @param bool|false $prepend
     * @return bool
     */
    protected function tryAddCompoundPart($component, $prepend = false)
    {
        /** @var CompoundComponent $root */
        $root = $this->parentNode;
        if (!$component instanceof CompoundPartInterface) {
            return false;
        }
        $parentName = $component->resolveParentName($this->getCompoundRoot());
        if ($parentName === null) {
            return false;
        }
        if (!$root->hasComponent($parentName)) {
            throw new NodeNotFoundException;
        }
        $componentName = $component->getComponentName();
        if (!$componentName) {
            $componentName = $this->getCompoundRoot()->getComponentName() . '_component_' . rand();
            $component->setComponentName($componentName);
        }
        $component->setRootInternal($this->getCompoundRoot());
        $prepend
            ? $root->prependComponent($parentName, $componentName, $component)
            : $root->appendComponent($parentName, $componentName, $component);
        return true;
    }

    /**
     * @param ComponentInterface $component
     * @param bool|false $prepend
     * @return $this
     */
    public function add($component, $prepend = false)
    {
        if (!$this->tryAddCompoundPart($component, $prepend)) {
            parent::add($component, $prepend);
        }
        return $this;
    }
}