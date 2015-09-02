<?php
namespace Presentation\Framework\Data\Processor;

use Presentation\Framework\Data\Operation\OperationInterface;

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
