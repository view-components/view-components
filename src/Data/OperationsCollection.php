<?php

namespace Presentation\Framework\Data;

use Nayjest\Collection\Extended\ObjectCollection;
use Presentation\Framework\Common\ChangesWatcherInterface;
use Presentation\Framework\Common\ChangesWatcherTrait;
use Presentation\Framework\Common\StateHashInterface;

/**
 * Class OperationsCollection
 *
 * Collection of operations applied to data provider.
 */
class OperationsCollection extends ObjectCollection implements
    ChangesWatcherInterface,
    StateHashInterface
{
    use ChangesWatcherTrait;
}
