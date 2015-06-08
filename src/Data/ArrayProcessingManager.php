<?php

namespace Nayjest\ViewComponents\Data;

use ArrayIterator;
use Traversable;

class ArrayProcessingManager extends AbstractProcessingManager
{

    /**
     * @param mixed $data
     * @return Traversable
     */
    protected function afterOperations($data)
    {
        return new ArrayIterator($data);
    }

    /**
     * @param mixed $data
     * @return mixed
     */
    protected function beforeOperations($data)
    {
        return $this->makeRowObjects($data);
    }

    /**
     * Makes array of objects from array of arrays.
     *
     * @param $src
     * @return array
     */
    private function makeRowObjects($src)
    {
        $newSrc = [];
        foreach ($src as $row) {
            $newSrc[] = is_array($row) ? (object)$row : $row;
        }
        return $newSrc;
    }
}
