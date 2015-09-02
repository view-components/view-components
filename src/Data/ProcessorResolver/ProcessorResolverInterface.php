<?php
namespace Presentation\Framework\Data\ProcessorResolver;

use Presentation\Framework\Data\Operation\OperationInterface;
use Presentation\Framework\Data\Processor\ProcessorInterface;

interface ProcessorResolverInterface
{
    /**
     * @param OperationInterface $operation
     * @return ProcessorInterface
     */
    public function getProcessor(OperationInterface $operation);
}
