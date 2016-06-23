<?php

namespace ViewComponents\ViewComponents\Component;

use Nayjest\Collection\Extended\ObjectCollection;
use ViewComponents\ViewComponents\Base\ComponentInterface;
use ViewComponents\ViewComponents\Base\Compound\PartInterface;
use ViewComponents\ViewComponents\Base\ContainerComponentInterface;
use ViewComponents\ViewComponents\Base\ContainerComponentTrait;
use ViewComponents\ViewComponents\Base\ViewComponentInterface;

/**
 * Base class for components composed from parts.
 * @see PartInterface
 * @see Part
 */
class Compound implements ContainerComponentInterface
{
    use ContainerComponentTrait {
        ContainerComponentTrait::children as private childrenInternal;
    }

    const ROOT_ID = 'root';

    /** @var ObjectCollection|PartInterface[] */
    private $componentCollection;

    private $isTreeReady = false;

    /**
     * Constructor.
     *
     * @param PartInterface[] $components compound parts
     */
    public function __construct(array $components)
    {
        $this->componentCollection = new ObjectCollection($components);
        $this->componentCollection->onChange([$this, 'requireTreeUpdate']);
        $this->componentCollection->onItemRemove(function (PartInterface $item) {
            $item->detach();
        });
        $this->componentCollection->onItemAdd(function (PartInterface $part) {
            if ($this->hasComponent($part->getId())) {
                $this->removeComponent($part->getId());
            }
        });
        $this->initializeCollection([]);
        $this->childrenInternal()->onItemAdd(function ($item) {
            if ($item instanceof PartInterface && !$this->componentCollection->contains($item)) {
                $this->componentCollection->add($item);
            }
        });
    }

    /**
     * @return ObjectCollection|PartInterface[]
     */
    public function getComponents()
    {
        return $this->componentCollection;
    }

    /**
     * Returns child components.
     *
     * This method is overridden to provide hierarchy update if components registry was changed.
     *
     * @return ObjectCollection
     */
    public function children()
    {
        $this->buildTree();
        return $this->childrenInternal();
    }

    /**
     * Renders component and returns output.
     *
     * @return string
     */
    public function render()
    {
        return $this->renderChildren();
    }

    /**
     * @param string $id
     * @param bool $extractView
     * @return PartInterface|ViewComponentInterface|Part|null
     */
    public function getComponent($id, $extractView = true)
    {
        $this->buildTree();
        /** @var PartInterface|Part $part */
        $part = $this->componentCollection->findByProperty('id', $id, true);
        return ($extractView && $part instanceof Part) ? $part->getView() : $part;
    }

    /**
     * @param ComponentInterface|PartInterface $component
     * @param string|null $id
     * @param string|null $defaultParent
     * @return $this
     */
    public function setComponent(ComponentInterface $component, $id = null, $defaultParent = null)
    {
        if ($component instanceof PartInterface) {
            $part = $component;
            if ($id !== null) {
                $part->setId($id);
            }
            if (!$part->getDestinationParentId() && $defaultParent !== null) {
                $part->setDestinationParentId($defaultParent);
            }
        } else {
            $part = new Part($component, $id, $defaultParent ?: Compound::ROOT_ID);
        }
        $this->getComponents()->add($part);
        return $this;
    }

    /**
     * Removes component from compound.
     *
     * @param string $id
     * @return $this
     */
    public function removeComponent($id)
    {
        /** @var PartInterface $component */
        $component = $this->getComponents()->findByProperty('id', $id, true);
        if ($component) {
            $this->getComponents()->remove($component);
        }
        return $this;
    }

    /**
     * @param ComponentInterface[] $components
     * @param string|null $defaultParent
     * @return $this
     */
    public function addComponents($components, $defaultParent = null)
    {
        foreach ($components as $component) {
            $this->setComponent($component, null, $defaultParent);
        }
        return $this;
    }

    /**
     * Returns true if compound contains component with specified ID.
     *
     * @param string $id
     * @return bool
     */
    public function hasComponent($id)
    {
        return (bool)$this->getComponents()->findByProperty('id', $id, true);
    }

    protected function buildTree()
    {
        if ($this->isTreeReady) {
            return;
        }
        $this->isTreeReady = true;
        foreach ($this->componentCollection as $component) {
            $component->attachToCompound($this);
        }
        if (!$this->isTreeReady) {
            $this->buildTree();
        }
    }

    public function requireTreeUpdate()
    {
        $this->isTreeReady = false;
    }
}
