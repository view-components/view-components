<?php

namespace Presentation\Framework\Base;

use Nayjest\Collection\Extended\ObjectCollection;
use Nayjest\Tree\ChildNodeInterface;
use Nayjest\Tree\ReadonlyNodeTrait;
use Nayjest\Tree\TreeBuilder;
use Presentation\Framework\Rendering\ViewTrait;
use Traversable;

class CompoundComponent implements ComponentInterface
{
    use ViewTrait;
    use ReadonlyNodeTrait {
        ReadonlyNodeTrait::children as private readonlyChildren;
    }
    use ComponentTrait;

    /**
     * @var array
     */
    protected $treeConfig = [];

    /**
     * Plain collection of compound components listed in treeConfig
     *
     * @var ComponentInterface[]|ObjectCollection $items
     */
    protected $componentCollection;

    /**
     * @var bool
     */
    protected $isTreeUpdateRequired = true;

    /**
     * @param array $tree
     * @param ComponentInterface[]|Traversable $components
     */
    public function __construct(array $tree = null, $components = null)
    {
        if ($tree !== null) {
            $this->setTreeConfig($tree);
        }
        if ($components !== null) {
            $this->components()->set($components);
        }
    }

    public function children()
    {
        if ($this->isTreeUpdateRequired) {
            $this->updateTree();
            $this->isTreeUpdateRequired = false;
        }
        return $this->readonlyChildren();
    }

    /**
     * @return array
     */
    public function getTreeConfig()
    {
        return $this->treeConfig;
    }

    /**
     * @param $treeConfig
     * @return $this
     */
    public function setTreeConfig(array $treeConfig)
    {
        $this->treeConfig = $treeConfig;
        $this->isTreeUpdateRequired = true;
        return $this;
    }

    /**
     * @return ObjectCollection|ComponentInterface[]
     */
    public function components()
    {
        if ($this->componentCollection === null) {
            $this->componentCollection = $this->defaultComponentsCollection();
            $this->componentCollection->onChange(function () {
                $this->isTreeUpdateRequired = true;
            });
        }
        return $this->componentCollection;
    }

    /**
     * @param ComponentInterface[]|Traversable $components
     * @return $this
     */
    public function setComponents($components)
    {
        $this->components()->set($components);
        return $this;
    }

    public function getComponents()
    {
        return $this->components();
    }

    /**
     * Returns default child components.
     *
     * To provide default components, override defaultComponentsCollection()
     *
     * @return ChildNodeInterface[]
     */
    protected function defaultChildren()
    {
        return $this->buildTree();
    }

    protected function buildTree()
    {
        $builder = new TreeBuilder();
        $plainItems = [];
        /** @var ComponentInterface $component */
        foreach ($this->componentCollection as $component) {
            $key = $component->getComponentName();
            if (array_key_exists($key, $plainItems)) {
                throw new \RuntimeException(
                    "Can't build component tree, there is few components named '$key' in componentCollection"
                );
            }
            $plainItems[$key] = $component;
        }
        return $builder->build($this->treeConfig, $plainItems);
    }

    protected function defaultComponentsCollection()
    {
        return new ObjectCollection();
    }

    protected function updateTree()
    {
        if ($this->collection) {
            $this->collection->set($this->defaultChildren());
        }
        $this->isTreeUpdateRequired = false;
    }
}
