<?php

namespace Nayjest\ViewComponents\Data;

use IteratorAggregate;

interface DataProviderInterface extends IteratorAggregate
{
    /**
     * @return OperationsCollection
     */
    public function operations();
}
