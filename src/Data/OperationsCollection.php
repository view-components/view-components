<?php

namespace Presentation\Framework\Data;

use Nayjest\Collection\Collection;
use Presentation\Framework\Common\ChangesWatcherInterface;
use Presentation\Framework\Common\ChangesWatcherTrait;
use Presentation\Framework\Common\StateHashInterface;

class OperationsCollection extends Collection implements
    ChangesWatcherInterface,
    StateHashInterface
{
    use ChangesWatcherTrait;
}
