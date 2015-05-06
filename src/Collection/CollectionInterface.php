<?php
namespace nayjest\ViewComponents\Collection;

use Countable;
use IteratorAggregate;

interface CollectionInterface extends IteratorAggregate, Countable
{
    public function toArray();

    public function isEmpty();

    //public function getSize();

    public function has($item);

    public function getIterator();

    public function first();
}
