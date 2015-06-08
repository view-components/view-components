<?php
namespace Nayjest\ViewComponents\Data\ProcessorResolvers;

use Nayjest\ViewComponents\Data\Operations\OperationInterface;
use Nayjest\ViewComponents\Data\Processors\ProcessorInterface;

interface ProcessorResolverInterface
{
    /**
     * @param OperationInterface $operation
     * @return ProcessorInterface
     */
    public function getProcessor(OperationInterface $operation);
}