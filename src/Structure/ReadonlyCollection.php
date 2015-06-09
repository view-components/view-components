<?php

namespace Nayjest\ViewComponents\Structure;

use Nayjest\ViewComponents\Collection\ReadonlyGroupedCollection as BaseCollection;

class ReadonlyCollection extends BaseCollection
{
    use TreeNodesCollectionTrait;
}