<?php

namespace ViewComponents\ViewComponents\Component;

use Nayjest\Collection\Decorator\ReadonlyObjectCollection;
use Nayjest\Collection\Extended\ObjectCollection;
use ViewComponents\ViewComponents\Base\Compound\CompoundPartInterface;
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
     * @param string $id
     * @return null|ViewComponentInterface
     */
    public function getComponent($id)
    {
        /** @var CompoundPartInterface $part */
        $part = $this->parts->findByProperty('id', $id, true);
        return $part ? $part->getView() : null;
    }

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

