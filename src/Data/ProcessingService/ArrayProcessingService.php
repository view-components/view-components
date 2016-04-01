<?php

namespace ViewComponents\ViewComponents\Data\ProcessingService;

use ArrayIterator;
use Traversable;

class ArrayProcessingService extends AbstractProcessingService
{

    /**
     * @return int
     */
    public function count()
    {
        /** @var ArrayIterator $data */
        $data = $this->getProcessedData();
        return $data->count();
    }

    /**
     * @param mixed $data
     * @return Traversable|ArrayIterator
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
