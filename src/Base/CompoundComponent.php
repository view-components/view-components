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
    protected $plainComponents;

    /**
     * @var bool
     */
    protected $isTreeUpdateRequired = true;

    /**
     * Constructor.
     *
     * @param array $tree
     * @param ComponentInterface[]|Traversable $components
     */
    public function __construct(array $tree = null, $components = null)
    {
        if ($tree !== null) {
            $this->setTreeConfig($tree);
        }
        if ($components !== null) {
            $this->getPlainComponents()->set($components);
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
    public function getPlainComponents()
    {
        if ($this->plainComponents === null) {
            $this->plainComponents = $this->makePlainComponentCollection();
            $this->plainComponents->onChange(function () {
                $this->isTreeUpdateRequired = true;
            });
        }
        return $this->plainComponents;
    }

    /**
     * @param ComponentInterface[]|Traversable $components
     * @return $this
     */
    public function setPlainComponents($components)
    {
        $this->getPlainComponents()->set($components);
        return $this;
    }

    /**
     * Returns default child components.
     *
     * To provide default components, override defaultComponentsCollection()
     *
     * @return ChildNodeInterface[]
     */
    final protected function defaultChildren()
    {
        return $this->buildTree();
    }


    protected function buildTree()
    {
        $builder = new TreeBuilder();

        // use component names as keys
        $plainItems = [];
        /** @var ComponentInterface $component */
        foreach ($this->getPlainComponents() as $component) {
            $key = $component->getComponentName();
            $plainItems[$key] = $component;
        }
        return $builder->build($this->treeConfig, $plainItems);
    }

    /**
     * Creates collection instance for plain components.
     *
     * @return ObjectCollection
     */
    protected function makePlainComponentCollection()
    {
        return new ObjectCollection();
    }

    protected function updateTree()
    {
        if ($this->collection) {
            $this->collection->set($this->buildTree());
        }
        $this->isTreeUpdateRequired = false;
    }
}
