<?php
namespace Nayjest\ViewComponents\Structure;

/**
 * Class ParentTrait
 *
 * @implements ParentInterface
 */
trait ParentTrait
{
    protected $componentsCollection;

    /**
     * Returns default child components.
     *
     * Override this method.
     *
     * @return ChildInterface[]
     */
    protected function defaultComponents()
    {
        return [];
    }

    private function createComponentsCollection()
    {
        $this->componentsCollection = new Collection($this);
        $defaults = $this->defaultComponents();
        if (count($defaults) !== 0) {
            $this->componentsCollection->set($defaults);
        }
    }

    /**
     * Returns child components.
     *
     * @return Collection
     */
    final public function components()
    {
        if ($this->componentsCollection === null) {
            $this->createComponentsCollection();
        }
        return $this->componentsCollection;
    }

    final public function setComponents(array $components = [])
    {
        $this->components()->set($components);
        return $this;
    }
}
