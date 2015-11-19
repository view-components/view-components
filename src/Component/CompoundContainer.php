<?php

namespace Presentation\Framework\Component;

use Nayjest\Collection\Decorator\ReadonlyObjectCollection;
use Nayjest\Tree\NodeCollection;
use Presentation\Framework\Base\ComponentInterface;

/**
 * CompoundContainer extends CompoundComponent and provides access
 * to it's terminal node children instead of it's own readonly children collection,
 * i.e. it hides it's real children from components tree.
 *
 */
class CompoundContainer extends CompoundComponent
{
    protected $terminalNodeName;

    /**
     * @param array|null $hierarchy
     * @param array $components
     * @param $terminalNodeName
     */
    public function __construct(array $hierarchy = [], $components = [], $terminalNodeName)
    {
        $this->terminalNodeName = $terminalNodeName;
        parent::__construct($hierarchy, $components);
    }

    /**
     * Returns child components.
     *
     * @overrides CompoundComponent::children()
     * This method is overriden to provide access to writable children of terminal node
     * instead of it's own readonly components.
     *
     * @return NodeCollection
     */
    public function children()
    {
        $this->tree->build();
        return $this->getTerminalNode()->children();
    }

    /**
     * @return ComponentInterface
     */
    protected function getTerminalNode()
    {
        return $this->getComponent($this->terminalNodeName);
    }

    /**
     * @overrides ComponentTrait::getChildrenForRendering()
     * because wee need CompoundComponent::children() -- real children collection
     * instead of CompoundContainer::children() which actually
     * points to $this->getTerminalNode()->children()
     *
     * @return ReadonlyObjectCollection|NodeCollection
     */
    protected function getChildrenForRendering()
    {
        $children = CompoundComponent::children();
        return $this->isSortingEnabled ? $children->sortByProperty('sortPosition') : $children;
    }
}
