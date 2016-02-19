<?php

namespace ViewComponents\ViewComponents\Component;

use Nayjest\Collection\Decorator\ReadonlyObjectCollection;
use Nayjest\Collection\Extended\ObjectCollection;
use ViewComponents\ViewComponents\Base\Compound\CompoundPartInterface;
use ViewComponents\ViewComponents\Base\ContainerComponentInterface;
use ViewComponents\ViewComponents\Base\ContainerComponentTrait;
use ViewComponents\ViewComponents\Base\Compound\CompoundPartCollection;
use ViewComponents\ViewComponents\Base\ViewComponentInterface;
use RuntimeException;


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

    /** @var ObjectCollection|CompoundPartInterface[] */
    private $parts;
    private $isTreeReady = false;

    /**
     * Compound constructor.
     * @param CompoundPartInterface[] $parts
     */
    public function __construct(array $parts)
    {
        $this->parts = new ObjectCollection($parts);
        $this->initializeCollection([]);
    }

    /**
     * @return ReadonlyObjectCollection
     */
    public function getComponents()
    {
        return new ReadonlyObjectCollection($this->parts);
    }

    /**
     * Returns child components.
     *
     * This method is overriden to provide hierarchy update if components registry was changed.
     *
     * @return CompoundPartCollection
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
     * @param string $id
     * @return null|ViewComponentInterface
     */
    public function getComponent($id)
    {
        /** @var CompoundPartInterface $part */
        $part = $this->parts->findByProperty('id', $id, true);
        return $part ? $part->getView() : null;
    }

//    public function removeComponent($id)
//    {
//        /** @var ViewComponentInterface $component */
//        $component = $this->parts->findByProperty('id',$id, true);
//        if ($component) {
//            $this->parts->remove($component);
//            $component->parent() && $component->detach();
//            $this->isTreeReady = false;
//        }
//    }
//
//
//    public function addComponent(CompoundPartInterface $component)
//    {
//        $this->removeComponent($component->getId());
//        $this->parts->add($component);
//        $this->isTreeReady = false;
//    }

//    protected function attachPart(CompoundPartInterface $component)
//    {
//        $parentId = $component->getDestinationParentId();
//        if ($parentId === static::ROOT_ID) {
//            $this->addChild($component);
//        } else {
//            /** @var CompoundPartInterface $parent */
//            $parent = $this->parts->findByProperty('id', $parentId, true);
//            if (!$parent) {
//                $id = $component->getId();
//                throw new RuntimeException(
//                    "Trying to attach compound part '$id' to not existing '$parentId'."
//                );
//            }
//            if ($component->parent() !== $parent->getInnerContainer()) {
//                $parent->getInnerContainer()->addChild($component);
//            }
//        }
//    }

    protected function buildTree()
    {
        if ($this->isTreeReady) {
            return;
        }
        $this->isTreeReady = true;
        foreach ($this->parts as $component) {
            $component->attachToCompound($this);
        }
    }
}

