<?php

namespace ViewComponents\ViewComponents\Data\ProcessingService;

use ViewComponents\ViewComponents\Data\DbTable\Query;
use Traversable;

/**
 * Class DbTableProcessingService
 */
class DbTableProcessingService extends AbstractProcessingService
{
    /**
     * @param Query $data
     * @return mixed
     */
    protected function beforeOperations($data)
    {
        # Clone query to not modify data source
        return clone $data;
    }

    /**
     * @param Query $data
     * @return Traversable|\PDOStatement
     */
    protected function afterOperations($data)
    {
        return $data->execute();
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->applyOperations(
            $this->beforeOperations($this->dataSource)
        )->count();
    }
}
