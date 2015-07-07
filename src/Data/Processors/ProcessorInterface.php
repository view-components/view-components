<?php
namespace Presentation\Framework\Data\Processors;

use Presentation\Framework\Data\Operations\OperationInterface;

interface ProcessorInterface
{
    /**
     * Applies operation to source and returns modified source.
     *
     * @param $src
     * @param OperationInterface $operation
     * @return mixed
     */
    public function process($src, OperationInterface $operation);
}
