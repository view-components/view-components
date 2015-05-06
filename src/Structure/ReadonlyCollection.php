<?php

namespace Nayjest\ViewComponents\Structure;

use Nayjest\ViewComponents\Collection\ReadonlyCollection as BaseCollection;

class ReadonlyCollection extends BaseCollection
{
    use TreeNodesCollectionTrait;
}