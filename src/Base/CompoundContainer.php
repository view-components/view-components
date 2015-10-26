<?php

namespace Presentation\Framework\Base;

use Nayjest\Collection\Decorator\ReadonlyObjectCollection;
use Nayjest\Tree\NodeCollection;

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
     * @param array|null $tree
     * @param array $components
     * @param $terminalNodeName
     */
    public function __construct(array $tree = [], $components = [], $terminalNodeName)
    {
        $this->terminalNodeName = $terminalNodeName;
        parent::__construct($tree, $components);
    }

    /**
     * Returns child components.
     *
     * This method is overriden to provide access to writable children of terminal node
     * instead of it's own readonly components.
     *
     * @return NodeCollection
     */
    public function children()
    {
        $this->updateTreeIfRequired();
        return $this->getTerminalNode()->children();
    }

    /**
     * @return ComponentInterface
     */
    protected function getTerminalNode()
    {
        return $this->components()->get($this->terminalNodeName);
    }

    /**
     * @return ReadonlyObjectCollection|NodeCollection
     */
    protected function getChildrenForRendering()
    {
        $children = CompoundComponent::children();
        return $this->isSortingEnabled ? $children->sortByProperty('sortPosition') : $children;
    }
}
