<?php

namespace Nayjest\ViewComponents\Data;

use Nayjest\ViewComponents\Data\DbTable\Query;
use RuntimeException;

/**
 * Class DbTableProcessingManager
 *
 * @package Nayjest\ViewComponents\Data
 */
class DbTableProcessingManager extends ProcessingManager
{
    /**
     * @param Query $src
     * @return bool
     */
    protected function process($src)
    {
        /** @var  Query $preparedQuery */
        $preparedQuery = parent::process($src);
        $statement = $preparedQuery->getPdoStatement();
        $result = $statement->execute($preparedQuery->bindings);
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
