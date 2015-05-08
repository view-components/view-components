<?php
namespace Nayjest\ViewComponents\Structure;

/**
 * Class ParentNodeTrait
 *
 * @implements ParentNodeInterface
 */
trait ParentNodeTrait
{
    protected $componentsCollection;

    /**
     * Returns default child components.
     *
     * Override this method.
     *
     * @return ChildNodeInterface[]
     */
    protected function defaultComponents()
    {
        return [];
    }

    private function createComponentsCollection()
    {
        $this->componentsCollection = new NodesCollection($this);
        $defaults = $this->defaultComponents();
        if (count($defaults) !== 0) {
            $this->componentsCollection->set($defaults);
        }
    }

    /**
     * Returns child components.
     *
     * @return NodesCollection
     */
    public function components()
    {
        if ($this->componentsCollection === null) {
            $this->createComponentsCollection();
        }
        return $this->componentsCollection;
    }

    public function setComponents(array $components = [])
    {
        $this->components()->set($components);
        return $this;
    }
}
