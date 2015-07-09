<?php
namespace Presentation\Framework\Collection;

use ArrayIterator;
use RuntimeException;

class Collection implements CollectionReadInterface
{
    protected $items = [];

    /**
     * Adds item to collection.
     *
     * @param $item
     * @param bool $prepend false by default
     * @return $this
     */
    public function add($item, $prepend = false)
    {
        if ($prepend) {
            array_unshift($this->items, $item);
        } else {
            $this->items[] = $item;
        }
        return $this;
    }

    /**
     * Removes item from collection.
     *
     * @param $item
     * @return $this
     */
    public function remove($item)
    {
        $key = array_search($item, $this->items, true);
        if ($key === false) {
            throw new RuntimeException(
                'Trying to remove nonexistent item from collection.'
            );
        }
        unset($this->items[$key]);
        return $this;
    }

    /**
     * Returns collection items in array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->items;
    }

    /**
     * Returns true if collection is empty.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return count($this->items) === 0;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * Checks that collections contains target item.
     *
     * @param $item
     * @return bool
     */
    public function has($item)
    {
        return in_array($item, $this->items, true);
    }

    /**
     * Sets collection items.
     *
     * @param array $items
     * @return $this
     */
    public function set(array $items)
    {
        $this->clear();
        foreach ($items as $item) {
            $this->add($item);
        }
        return $this;
    }

    /**
     * Removes all items from collection.
     *
     * @return $this
     */
    public function clear()
    {
        $this->items = [];
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    public function first()
    {
        return $this->isEmpty() ? null : array_values($this->items)[0];
    }

    /**
     * @draft
     *
     * @param string $className
     * @return array
     */
    public function ofType($className)
    {
        $res = [];
        foreach($this->items as $item) {
            if ($item instanceof $className) {
                $res[] = $item;
            }
        }
        return $res;
    }

    /**
     * @draft
     *
     * @param $className
     * @return null
     */
    public function firstOfType($className)
    {
        foreach($this->items as $item) {
            if ($item instanceof $className) {
                return $item;
            }
        }
        return null;
    }
}
