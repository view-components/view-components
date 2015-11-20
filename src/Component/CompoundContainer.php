<?php

namespace Presentation\Framework\Component;

use Nayjest\Collection\Decorator\ReadonlyObjectCollection;
use Nayjest\Collection\Extended\ObjectCollection;
use Nayjest\Tree\NodeCollection;
use Presentation\Framework\Base\AbstractComponent;
use Presentation\Framework\Base\ComponentInterface;
use Presentation\Framework\Common\TreeAggregate;

/**
 * CompoundContainer extends CompoundComponent and provides access
 * to it's terminal node children instead of it's own readonly children collection,
 * i.e. it hides it's real children from components tree.
 *
 */
class CompoundContainer  extends AbstractComponent
{
    use TreeAggregate
    {
        TreeAggregate::getTree as private getTreeInternal;
    }
    protected $terminalNodeName;
    protected $compound;

    /**
     * @param array|null $hierarchy
     * @param array $components
     * @param $terminalNodeName
     */
    public function __construct(array $hierarchy = [], $components = [], $terminalNodeName)
    {
        $this->compound = new CompoundComponent($hierarchy, $components);
        $this->terminalNodeName = $terminalNodeName;
    }

    public function getTree()
    {
        return $this->compound->getTree();
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
        return new ObjectCollection([$this->compound]);
    }
}
