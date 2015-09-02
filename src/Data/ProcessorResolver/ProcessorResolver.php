<?php

namespace Presentation\Framework\Data\ProcessorResolver;

use Presentation\Framework\Data\Operation\OperationInterface;
use Presentation\Framework\Exceptions\ProcessorNotFoundException;

/**
 * Class ProcessorResolver
 *
 * Basic ProcessorResolver implementation.
 */
class ProcessorResolver implements ProcessorResolverInterface
{
    protected $processors = [
        'Presentation\Framework\Data\Operations\DummyOperation' =>
        '\Presentation\Framework\Data\Processors\DummyProcessor'
    ];

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
