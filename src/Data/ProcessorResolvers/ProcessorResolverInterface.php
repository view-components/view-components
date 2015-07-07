<?php
namespace Presentation\Framework\Data\ProcessorResolvers;

use Presentation\Framework\Data\Operations\OperationInterface;
use Presentation\Framework\Data\Processors\ProcessorInterface;

interface ProcessorResolverInterface
{
    /**
     * @param OperationInterface $operation
     * @return ProcessorInterface
     */
    public function getProcessor(OperationInterface $operation);
}
