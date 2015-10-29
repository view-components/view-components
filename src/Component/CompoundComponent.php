<?php

namespace Presentation\Framework\Component;

use InvalidArgumentException;
use Nayjest\Collection\Decorator\ReadonlyObjectCollection;
use Nayjest\Collection\Extended\ObjectCollection;
use Nayjest\Collection\Extended\Registry;
use Nayjest\Collection\Extended\RegistryInterface;
use Nayjest\Tree\ChildNodeInterface;
use Nayjest\Tree\ReadonlyNodeTrait;
use Nayjest\Tree\TreeBuilder;
use Presentation\Framework\Base\ComponentInterface;
use Presentation\Framework\Base\ComponentTrait;
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
    protected $treeConfig;

    /**
     * @var TreeBuilder
     */
    protected $treeBuilder;

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
    public function __construct(array $tree = [], $components = [])
    {
        $this->componentRegistry = $this->makeComponentRegistry($components);
        $this->watchComponentChanges();
        $this->setTreeConfig($tree);
    }

    /**
     * Returns child components.
     *
     * This method is overriden to provide hierarchy update if components registry was changed.
     * Children collection is read-only to avoid adding components to tree that can be removed on tree update.
     *
     * @return ReadonlyObjectCollection
     */
    public function children()
    {
        $this->updateTreeIfRequired();
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
     * Sets tree configuration.
     *
     * Tree config keys corresponds to keys in components registry (@see CompoundComponent::components()).
     * Values are arrays in same format.
     *
     * @param array $treeConfig
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

    /**
     * Returns new instance of component registry and initializes it with components.
     *
     * @param array $components
     * @return RegistryInterface
     */
    protected function makeComponentRegistry(array $components = [])
    {
        return new Registry($components);
    }

    protected function watchComponentChanges()
    {
        $this->componentRegistry->onChange(function () {
            $this->isTreeUpdateRequired = true;
        });
    }

    /**
     * @param string $parentName
     * @param string $componentName
     * @param ComponentInterface|null $component
     * @return bool
     */
    public function compose($parentName, $componentName, ComponentInterface $component = null)
    {
        self::removeTreeChildIfExists($this->treeConfig, $componentName);
        if (!self::addTreeChild($this->treeConfig, $parentName, $componentName)) {
            throw new InvalidArgumentException(
                "Can't insert '$componentName' node into tree config: parent node '$parentName' not found"
            );
        }
        $this->components()->set($componentName, $component);
        return true;
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

    /**
     * Builds component tree and returns it.
     *
     * @return ComponentInterface[]
     */
    protected function buildTree()
    {
        if (!$this->treeBuilder) {
            $this->treeBuilder = new TreeBuilder();
        }
        return $this->treeBuilder->build($this->getTreeConfig(), $this->components()->toArray());
    }

    /**
     * Updates components hierarchy if required.
     */
    protected function updateTreeIfRequired()
    {
        if (!$this->isTreeUpdateRequired) {
            return;
        }
        $this->writableChildren()->set($this->buildTree());
        $this->isTreeUpdateRequired = false;
    }

    /**
     * @param array $config
     * @param string $parent node name or null for inserting into root node
     * @param $node
     * @return bool false if no parent found
     */
    final protected static function addTreeChild(array &$config, $parent, $node)
    {
        if ($parent === null) {
            $config[$node] = [];
            return true;
        }
        foreach($config as $key => &$value) {
            if ($key === $parent) {
                $value[$node] = [];
                return true;
            } else {
                if (self::addTreeChild($value, $parent, $node)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param array $config
     * @param $node
     * @return bool
     */
    final protected static function removeTreeChildIfExists(array &$config, $node)
    {
        foreach($config as $key => &$value) {
            if ($key === $node) {
                unset($config[$node]);
                return true;
            } else {
                if (self::removeTreeChildIfExists($value, $node)) {
                    return true;
                }
            }
        }
        return false;
    }
}
