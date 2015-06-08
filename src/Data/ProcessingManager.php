<?php

namespace Nayjest\ViewComponents\Data;

use ArrayIterator;
use Traversable;

class ProcessingManager
{
    /** @var OperationsCollection  */
    protected $operations;

    /** @var ProcessorResolverInterface  */
    protected $processorResolver;

    /** @var  mixed */
    protected $dataSource;

    /** @var  Traversable */
    protected $processedData;

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
     * @param $dataSource
     * @return $this
     */
    public function setDataSource($dataSource)
    {
        if ($this->dataSource !== $dataSource) {
            $this->dataSource = $dataSource;
            $this->processedData = null;
        }
        return $this;
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
            if (is_array($this->processedData)) {
                $this->processedData = new ArrayIterator($this->processedData);
            }
        }
        return $this->processedData;
    }

    /**
     * @param $src
     * @return Traversable|array
     */
    protected function process($src)
    {
        foreach ($this->operations->toArray() as $operation) {
            $processor = $this->processorResolver->getProcessor($operation);
            $src = $processor->process($src, $operation);
        }
        return $src;
    }
}
