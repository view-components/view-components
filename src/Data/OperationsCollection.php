<?php

namespace Nayjest\ViewComponents\Data;

use Nayjest\ViewComponents\Collection\Collection;
use Nayjest\ViewComponents\Common\ChangesWatcherInterface;
use Nayjest\ViewComponents\Common\ChangesWatcherTrait;
use Nayjest\ViewComponents\Common\StateHashInterface;

class OperationsCollection extends Collection implements
    ChangesWatcherInterface,
    StateHashInterface
{
    use ChangesWatcherTrait;
}
