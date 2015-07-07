<?php

namespace Presentation\Framework\Structure;

use Presentation\Framework\Collection\ReadonlyGroupedCollection as BaseCollection;

class ReadonlyCollection extends BaseCollection
{
    use TreeNodesCollectionTrait;
}