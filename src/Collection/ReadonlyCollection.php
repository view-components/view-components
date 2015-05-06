<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06.05.2015
 * Time: 17:09
 */

namespace Nayjest\ViewComponents\Structure;


use nayjest\ViewComponents\Collection\CollectionInterface;

class ReadonlyCollection implements CollectionInterface
{
    protected $collection;

    public function __construct(CollectionInterface $collection)
    {
        $this->collection = $collection;
    }

    public function toArray()
    {
        return $this->collection->toArray();
    }

    public function isEmpty()
    {
        return $this->collection->isEmpty();
    }

    public function count()
    {
        return $this->collection->count();
    }

    public function has($item)
    {
        return $this->collection->has($item);
    }

    public function getIterator()
    {
        return $this->collection->getIterator();
    }

    public function first()
    {
        return $this->collection->first();
    }
}