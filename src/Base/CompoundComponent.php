<?php

namespace Presentation\Framework\Base;

use Nayjest\Collection\Extended\ObjectCollection;
use Nayjest\Collection\Extended\Registry;
use Nayjest\Tree\ChildNodeInterface;
use Nayjest\Tree\ReadonlyNodeTrait;
use Nayjest\Tree\TreeBuilder;
use Presentation\Framework\Rendering\ViewTrait;
use Traversable;

/**
 * CompoundComponent contains tree configuration and plain components list.
 * The class builds components tree and provides readonly access to it via children() method.
 *
 */
class CompoundComponent implements ComponentInterface
{
    use ViewTrait;
    use ReadonlyNodeTrait {
        ReadonlyNodeTrait::children as protected readonlyChildren;
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
    protected $componentRegistry;

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
    public function __construct(array $tree = null, $components = [])
    {
        $this->initializeComponentRegistry($components);
        if ($tree !== null) {
            $this->setTreeConfig($tree);
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
     * @return Registry|ComponentInterface[]
     */
    public function components()
    {
        return $this->componentRegistry;
    }

    protected function initializeComponentRegistry(array $components = [])
    {
        $this->componentRegistry = new Registry($components);
        $this->watchComponentChanges();
    }

    protected function watchComponentChanges()
    {
        $this->componentRegistry->onChange(function () {
            $this->isTreeUpdateRequired = true;
        });
    }

    /**
     * Returns default child components.
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
        return $builder->build($this->getTreeConfig(), $this->components()->toArray());
    }

    protected function updateTree()
    {
        if ($this->collection) {
            $this->collection->set($this->buildTree());
        }
        $this->isTreeUpdateRequired = false;
    }
}
