<?php

namespace ViewComponents\ViewComponents\Data\ProcessorResolver;

use ViewComponents\ViewComponents\Data\Operation\CustomOperation;
use ViewComponents\ViewComponents\Data\Operation\DummyOperation;
use ViewComponents\ViewComponents\Data\Operation\OperationInterface;
use ViewComponents\ViewComponents\Data\Processor\CustomProcessor;
use ViewComponents\ViewComponents\Data\Processor\DummyProcessor;
use ViewComponents\ViewComponents\Data\Processor\ProcessorInterface;
use ViewComponents\ViewComponents\Exceptions\ProcessorNotFoundException;

/**
 * Class ProcessorResolver
 *
 * Basic ProcessorResolver implementation.
 */
class ProcessorResolver implements ProcessorResolverInterface
{
    protected $processors = [
        DummyOperation::class => DummyProcessor::class,
        CustomOperation::class => CustomProcessor::class
    ];

    /**
     * Registers operation processor.
     *
     * @param string $operationClass
     * @param string $processorClass
     * @return $this
     */
    public function register($operationClass, $processorClass)
    {
        $this->processors[$operationClass] = $processorClass;
        return $this;
    }

    /**
     * Returns operation processor instance.
     *
     * @param OperationInterface $operation
     * @return ProcessorInterface
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
