<?php

namespace ViewComponents\ViewComponents\Data\ProcessingService;

use ViewComponents\ViewComponents\Data\DbTable\Query;
use Traversable;

/**
 * Class DbTableProcessingManager
 *
 * @package ViewComponents\ViewComponents\Data
 */
class DbTableProcessingService extends AbstractProcessingService
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
     * @return int
     */
    public function count()
    {
        return $this->applyOperations(
            $this->beforeOperations($this->dataSource)
        )->count();
    }
}
