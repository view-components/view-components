<?php

namespace Presentation\Framework\Data\ProcessorResolver;

use Presentation\Framework\Data\Operation\DummyOperation;
use Presentation\Framework\Data\Operation\OperationInterface;
use Presentation\Framework\Data\Processor\DummyProcessor;
use Presentation\Framework\Data\Processor\ProcessorInterface;
use Presentation\Framework\Exceptions\ProcessorNotFoundException;

/**
 * Class ProcessorResolver
 *
 * Basic ProcessorResolver implementation.
 */
class ProcessorResolver implements ProcessorResolverInterface
{
    protected $processors = [
        DummyOperation::class => DummyProcessor::class
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
