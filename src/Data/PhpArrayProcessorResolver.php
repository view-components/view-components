<?php
namespace Nayjest\ViewComponents\Data;

use Nayjest\ViewComponents\Data\Operations\OperationInterface;
use Nayjest\ViewComponents\Data\Processors\ProcessorInterface;

class PhpArrayProcessorResolver implements ProcessorResolverInterface
{
    protected static $processors = [
        'Nayjest\ViewComponents\Data\Operations\Sorting'
        => 'Nayjest\ViewComponents\Data\Processors\PhpArray\SortingProcessor',
        'Nayjest\ViewComponents\Data\Operations\Filter'
        => 'Nayjest\ViewComponents\Data\Processors\PhpArray\FilterProcessor'
    ];

    /**
     * @param OperationInterface $operation
     * @return ProcessorInterface
     */
    public function getProcessor(OperationInterface $operation)
    {
        $class = get_class($operation);
        $processorClass = self::$processors[$class];
        return new $processorClass();
    }
}
