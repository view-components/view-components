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
     */
    protected function addCompoundPart(CompoundPartInterface $component, $prepend = false)
    {
        $this->placeInTree($component, $prepend);
        $component->setRootInternal($this->getCompoundRoot());
    }

    /**
     * @param CompoundPartInterface $component
     * @param bool $prepend
     */
    private function placeInTree(CompoundPartInterface $component, $prepend = false)
    {
        $root = $this->getCompoundRoot();
        $parentName = $component->resolveParentName($root);
        if ($parentName !== null && !$root->hasComponent($parentName)) {
            throw new NodeNotFoundException;
        }
        $this->provideNameIfEmpty($component);
        $prepend
            ? $root->prependComponent($parentName, $component->getComponentName(), $component)
            : $root->appendComponent($parentName, $component->getComponentName(), $component);
    }

    /**
     * Adding to tree requires nodes naming.
     * Node names are stored by tree internally, so there is no need of storing name inside node.
     * However we use component_name as tree node name for convenience
     * since it can't be returned by $collection->add.
     * Therefore we need to provide component_name if it's empty.
     *
     * @param CompoundPartInterface $component
     */
    private function provideNameIfEmpty(CompoundPartInterface $component)
    {
        if (!$component->getComponentName()) {
            $component->setComponentName(
                $this->getCompoundRoot()->getComponentName() . '_component_' . rand()
            );
        }
    }

    /**
     * @param ComponentInterface $component
     * @param bool|false $prepend
     * @return $this
     */
    public function add($component, $prepend = false)
    {
        if ($component instanceof CompoundPartInterface) {
            $this->addCompoundPart($component, $prepend);
        } else {
            parent::add($component, $prepend);
        }
        return $this;
    }
}