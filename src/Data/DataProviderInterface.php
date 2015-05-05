<?php

namespace Nayjest\ViewComponents\Data;

use Traversable;

interface DataProviderInterface extends Traversable
{
    /**
     * @return OperationsCollection
     */
    public function operations();
}
