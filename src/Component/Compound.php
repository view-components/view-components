<?php

namespace ViewComponents\ViewComponents\Component;

use Nayjest\Collection\Decorator\ReadonlyObjectCollection;
use Nayjest\Collection\Extended\ObjectCollection;
use ViewComponents\ViewComponents\Base\ComponentInterface;
use ViewComponents\ViewComponents\Base\Compound\PartInterface;
use ViewComponents\ViewComponents\Base\ContainerComponentInterface;
use ViewComponents\ViewComponents\Base\ContainerComponentTrait;
use ViewComponents\ViewComponents\Base\ViewComponentInterface;

/**
 * Compound contains hierarchy configuration and plain components list.
 *
 */
class Compound implements ContainerComponentInterface
{
    const ROOT_ID = 'root';

    use ContainerComponentTrait {
        ContainerComponentTrait::children as private childrenInternal;
    }

    /** @var ObjectCollection|PartInterface[] */
    private $componentCollection;

    private $isTreeReady = false;

    /**
     * Compound constructor.
     * @param PartInterface[] $components
     */
    public function __construct(array $components)
    {
        $this->componentCollection = new ObjectCollection($components);
        $this->componentCollection->onChange(function(){
            $this->isTreeReady = false;
        });
        $this->componentCollection->onItemRemove(function(PartInterface $item) {
            $item->detach();
        });
        $this->componentCollection->onItemAdd(function(PartInterface $part) {
            if ($this->hasComponent($part->getId())) {
                $this->removeComponent($part->getId());
            }
        });
        $this->initializeCollection([]);
        $this->childrenInternal()->onItemAdd(function($item) {
            if ($item instanceof PartInterface && !$this->componentCollection->contains($item)) {
                $this->componentCollection->add($item);
            }
        });
    }

    /**
     * @return ObjectCollection
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

    public function render()
    {
        return $this->renderChildren();
    }

    /**
     * @param $id
     * @param bool $extractView
     * @return null|PartInterface|ViewComponentInterface|Part
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
        $part = $component instanceof PartInterface ? $component : new Part($component);
        $id && $part->setId($id);
        !$part->getDestinationParentId() && $defaultParent && $part->setDestinationParentId($defaultParent);
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
        foreach($components as $component) {
            $this->setComponent($component, null, $defaultParent);
        }
        return $this;
    }

    /**
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
}
