<?php

namespace ViewComponents\ViewComponents\Data;

use Nayjest\Collection\Extended\ObjectCollection;
use ViewComponents\ViewComponents\Common\ChangesWatcherInterface;
use ViewComponents\ViewComponents\Common\ChangesWatcherTrait;
use ViewComponents\ViewComponents\Common\StateHashInterface;

/**
 * Collection of operations applied to data provider.
 */
class OperationCollection extends ObjectCollection implements
    ChangesWatcherInterface,
    StateHashInterface
{
    use ChangesWatcherTrait;
}
