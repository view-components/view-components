<?php
namespace Presentation\Framework\Data\Processors;

use Presentation\Framework\Data\Operations\OperationInterface;

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
