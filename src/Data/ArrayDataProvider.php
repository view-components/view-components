<?php

namespace Nayjest\ViewComponents\Data;

class ArrayDataProvider extends AbstractDataProvider
{
    public function __construct($src, array $operations = [])
    {
        $this->operationsCollection = new OperationsCollection();
        $this->operationsCollection->set($operations);

        $this->processingManager = new ProcessingManager(
            new ArrayProcessorResolver(),
            $this->operationsCollection,
            $this->makeRowObjects($src)
        );
    }

    /**
     * @param $src
     * @return array
     */
    protected function makeRowObjects($src)
    {
        $newSrc = [];
        foreach($src as $row) {
            $newSrc[] = is_array($row)?(object)$row:$row;
        }
        return $newSrc;
    }
}
