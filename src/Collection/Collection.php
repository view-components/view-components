<?php
namespace Nayjest\ViewComponents\Collection;

use ArrayIterator;
use RuntimeException;

class Collection implements CollectionReadInterface
{
    protected $items = [];

    public function add($item, $prepend = false)
    {

        if ($prepend) {
            array_unshift($this->items, $item);
        } else {
            $this->items[] = $item;
        }
        return $this;
    }

    public function remove($item)
    {
        $key = array_search($item, $this->items, true);
        if ($key === false) {
            throw new RuntimeException(
                'Removing nonexistent item from collection.'
            );
        }
        unset($this->items[$key]);
        return $this;
    }

    public function toArray()
    {
        return $this->items;
    }

    public function isEmpty()
    {
        return count($this->items) === 0;
    }

    public function count()
    {
        return count($this->items);
    }

    public function has($item)
    {
        return in_array($item, $this->items, true);
    }

    public function set(array $items)
    {
        $this->clean();
        foreach ($items as $item) {
            $this->add($item);
        }
        return $this;
    }

    public function clean()
    {
        $this->items = [];
        return $this;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    public function first()
    {
        return $this->isEmpty() ? null : array_values($this->items)[0];
    }
}
