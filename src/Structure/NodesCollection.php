<?php

namespace Nayjest\ViewComponents\Structure;

use InvalidArgumentException;
use Nayjest\ViewComponents\Collection\Collection as BaseCollection;

/**
 * Class NodesCollection
 *
 * Tree nodes collection.
 *
 * @property ChildNodeInterface[] $items
 */
class NodesCollection extends BaseCollection
{
    use TreeNodesCollectionTrait;

    protected $owner;

    /**
     * Constructor.
     *
     * @param ParentNodeInterface $owner
     */
    public function __construct(ParentNodeInterface $owner)
    {
        $this->owner = $owner;
    }

    /**
     * Adds component to collection.
     *
     * If component is already in collection, it will not be added twice.
     *
     * @param ChildNodeInterface $item
     * @param bool $prepend Pass true to add component to the beginning of an array.
     * @return $this
     */
    public function add($item, $prepend = false)
    {
        if (!$item instanceof ChildNodeInterface) {
            throw new InvalidArgumentException('Collection accepts only objects implementing ChildNodeInterface');
        }
        $old = $item->getParent();
        if ($old !== $this->owner) {
            if ($old !== null) {
                $item
                    ->getParent()
                    ->components()
                    ->remove($item);
            }
            parent::add($item, $prepend);
            $item->internalSetParent($this->owner);
        }
        return $this;
    }

    /**
     * @param ChildNodeInterface $item
     * @return $this
     */
    public function remove($item)
    {
        if ($item->getParent() === $this->owner) {
            $item->internalUnsetParent();
            parent::remove($item);
        }
        return $this;
    }

    /**
     * @param ChildNodeInterface[] $items
     * @return $this
     */
    public function set(array $items)
    {
        return parent::set($items);
    }

    public function clear()
    {
        foreach ($this->items as $item) {
            $item->internalUnsetParent();
        }
        return parent::clear();
    }

    public function readonly()
    {
        return new ReadonlyCollection($this);
    }
}
