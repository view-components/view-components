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
        return $data;
    }

    /**
     * @param Query $data
     * @return Traversable
     */
    protected function afterOperations($data)
    {
        $statement = $data->getPdoStatement();
        $result = $statement->execute($data->bindings);
        if (!$result) {
            $errorInfo = $statement->errorInfo();
            throw new RuntimeException(
                $errorInfo[1],
                $errorInfo[2]
            );
        }
        return $statement;
    }
}
