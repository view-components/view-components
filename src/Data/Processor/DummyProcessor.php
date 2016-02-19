<?php
namespace ViewComponents\ViewComponents\Data\Processor;

use ViewComponents\ViewComponents\Data\Operation\OperationInterface;

class DummyProcessor implements ProcessorInterface
{
    /**
     * @param $src
     * @param OperationInterface $operation
     * @return mixed
     */
    public function process($src, OperationInterface $operation)
    {
        return $src;
    }
}
