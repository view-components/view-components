<?php

namespace Nayjest\ViewComponents\Data;

use Nayjest\ViewComponents\Data\DbTable\Query;
use RuntimeException;
use Traversable;

/**
 * Class DbTableProcessingManager
 *
 * @package Nayjest\ViewComponents\Data
 */
class DbTableProcessingManager extends AbstractProcessingManager
{

    protected function beforeOperations($data)
    {
        # Clone query to not modify data source
        return clone $data;
    }

    /**
     * @param Query $data
     * @return Traversable
     */
    protected function afterOperations($data)
    {
        return $data->execute();
    }

    /**
     * @return Query
     */
    public function count()
    {
        return $this->applyOperations(
            $this->beforeOperations($this->dataSource)
        )->count();
    }
}
