<?php
namespace ViewComponents\ViewComponents\Data\ProcessorResolver;

use ViewComponents\ViewComponents\Data\Operation\OperationInterface;
use ViewComponents\ViewComponents\Data\Processor\ProcessorInterface;

interface ProcessorResolverInterface
{
    /**
     * @param OperationInterface $operation
     * @return ProcessorInterface
     */
    public function getProcessor(OperationInterface $operation);
}
