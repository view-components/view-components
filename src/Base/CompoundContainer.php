<?php

namespace Presentation\Framework\Base;

/**
 * CompoundContainer extends CompoundComponent and provides access
 * to it's terminal node children instead of it's own readonly children collection.
 *
 */
class CompoundContainer extends CompoundComponent
{
    protected $terminalNodeName;

    public function __construct(array $tree = null, $components = [], $terminalNodeName)
    {
        $this->terminalNodeName = $terminalNodeName;
        parent::__construct($tree, $components);
    }

    public function children()
    {
        if ($this->isTreeUpdateRequired) {
            $this->updateTree();
            $this->isTreeUpdateRequired = false;
        }
        return $this->getTerminalNode()->children();
    }

    /**
     * @return ComponentInterface
     */
    protected function getTerminalNode()
    {
        return $this->components()->get($this->terminalNodeName);
    }

    protected function getChildrenForRendering()
    {
        $children = CompoundComponent::children();
        return $this->isSortingEnabled ? $children->sortByProperty('sortPosition') : $children;
    }
}
