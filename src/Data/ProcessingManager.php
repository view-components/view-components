<?php

namespace Nayjest\ViewComponents\Data;

class ProcessingManager
{
    protected $operations;
    protected $processorResolver;
    protected $dataSource;
    protected $processedData;
    protected $lastKey;

    protected static $processors = [
        'Nayjest\ViewComponents\Data\Operations\Sorting' => 'Nayjest\ViewComponents\Data\Processors\Sorting',
        'Nayjest\ViewComponents\Data\Operations\Filter' => 'Nayjest\ViewComponents\Data\Processors\FilterProcessor'
    ];

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


    protected function process($src)
    {
        foreach ($this->operations->toArray() as $operation) {
            $processor = $this->processorResolver->getProcessor($operation);
            $src = $processor->process($src, $operation);
        }
        return $src;
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
        $key = $this->operations->getStateKey();
        if ($this->processedData === null || $key !== $this->lastKey) {
            $this->processedData = $this->process($this->dataSource);
            $this->lastKey = $key;
        }
        return $this->processedData;
    }
}
