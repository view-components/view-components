<?php

namespace Presentation\Framework\Data\ProcessingServices;

use Presentation\Framework\Data\OperationsCollection;
use Presentation\Framework\Data\ProcessorResolvers\ProcessorResolverInterface;
use Traversable;

abstract class AbstractProcessingService implements ProcessingServiceInterface
{
    /** @var OperationsCollection  */
    protected $operations;

    /** @var ProcessorResolverInterface  */
    protected $processorResolver;

    /** @var  mixed */
    protected $dataSource;

    /** @var  Traversable */
    protected $processedData;

    abstract public function count();

    /**
     * @param mixed $data
     * @return mixed
     */
    abstract protected function beforeOperations($data);

    /**
     * @param mixed $data
     * @return Traversable
     */
    abstract protected function afterOperations($data);

    /**
     * @param ProcessorResolverInterface $processorResolver
     * @param OperationsCollection $operations
     * @param $dataSource
     */
    public function __construct(
        ProcessorResolverInterface $processorResolver,
        OperationsCollection $operations,
        $dataSource
    )
    {
        $this->operations = $operations;
        $this->processorResolver = $processorResolver;
        $this->dataSource = $dataSource;
    }

    /**
     * @return Traversable
     */
    public function getProcessedData()
    {
        if (
            $this->processedData === null
            || $this->operations->isChanged()
        ) {
            $this->processedData = $this->process($this->dataSource);
        }
        return $this->processedData;
    }

    /**
     * @param mixed $data
     * @return mixed
     */
    protected function applyOperations($data)
    {
        foreach ($this->operations->toArray() as $operation) {
            $processor = $this->processorResolver->getProcessor($operation);
            $data = $processor->process($data, $operation);
        }
        return $data;
    }

    /**
     * @param $src
     * @return Traversable
     */
    protected function process($src)
    {
        return $this->afterOperations(
            $this->applyOperations(
                $this->beforeOperations($src)
            )
        );
    }
}
