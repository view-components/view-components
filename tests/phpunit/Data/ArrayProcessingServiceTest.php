<?php

namespace ViewComponents\ViewComponents\Test\Data;

use ViewComponents\ViewComponents\Data\OperationCollection;
use ViewComponents\ViewComponents\Data\ProcessingService\ArrayProcessingService;
use ViewComponents\ViewComponents\Data\ProcessorResolver\ArrayProcessorResolver;

class ArrayProcessingServiceTest extends AbstractProcessingServiceTest
{
    public function setUp()
    {
        $this->data = include TESTING_HELPERS_DIR . '/resources/fixtures/users.php';
        $this->operations = new OperationCollection();
        $this->service = new ArrayProcessingService(
            new ArrayProcessorResolver(),
            $this->operations,
            $this->data
        );
        $this->totalCount = count($this->data);
    }
}