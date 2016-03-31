<?php
namespace ViewComponents\ViewComponents\Data\Processor;

use ViewComponents\ViewComponents\Data\Operation\OperationInterface;

interface ProcessorInterface
{
    /**
     * Applies operation to data source and returns modified data source.
     *
     * @param $src
     * @param OperationInterface $operation
     * @return mixed modified data source
     */
    public function process($src, OperationInterface $operation);
}
