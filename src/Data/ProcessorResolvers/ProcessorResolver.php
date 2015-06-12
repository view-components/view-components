<?php

namespace Nayjest\ViewComponents\Data\ProcessorResolvers;

use Nayjest\ViewComponents\Data\Operations\OperationInterface;
use Nayjest\ViewComponents\Exceptions\ProcessorNotFoundException;

/**
 * Class ProcessorResolver
 *
 * Basic ProcessorResolver implementation.
 */
class ProcessorResolver implements ProcessorResolverInterface
{
    protected $processors = [];

    public function register($operation, $processor)
    {
        $this->processors[$operation] = $processor;
        return $this;
    }

    /**
     * @param OperationInterface $operation
     * @return mixed
     */
    public function getProcessor(OperationInterface $operation)
    {
        $operationClass = get_class($operation);
        if (!array_key_exists($operationClass, $this->processors)) {
            throw new ProcessorNotFoundException(
                $operationClass,
                get_class($this)
            );
        }
        $processorClass = $this->processors[$operationClass];
        return new $processorClass();
    }
}
