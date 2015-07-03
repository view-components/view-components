<?php
namespace Nayjest\ViewComponents\Data\Processors;

use Nayjest\ViewComponents\Data\Operations\OperationInterface;

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
