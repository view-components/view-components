<?php

namespace Presentation\Framework\Data;

use Countable;
use IteratorAggregate;

interface DataProviderInterface extends IteratorAggregate, Countable
{
    /**
     * @return OperationsCollection
     */
    public function operations();
}
