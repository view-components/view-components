<?php
namespace Presentation\Framework\Collection;

use Countable;
use IteratorAggregate;

interface CollectionReadInterface extends IteratorAggregate, Countable
{
    public function toArray();

    public function isEmpty();

    public function has($item);

    public function getIterator();

    public function first();
}
