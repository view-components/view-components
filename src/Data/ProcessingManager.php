<?php

namespace Nayjest\ViewComponents\Data;

class ProcessingManager
{
    protected $operations;
    protected $processorResolver;
    protected $dataSource;
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

    public function setDataSource($dataSource)
    {
        if ($this->dataSource !== $dataSource) {
            $this->dataSource = $dataSource;
            $this->processedData = null;
        }
    }

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

    protected function process($src)
    {
        foreach ($this->operations->toArray() as $operation) {
            $processor = $this->processorResolver->getProcessor($operation);
            $src = $processor->process($src, $operation);
        }
        return $src;
    }
}
