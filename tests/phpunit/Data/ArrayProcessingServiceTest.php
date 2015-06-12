<?php

namespace Nayjest\ViewComponents\Test\Data;

use Nayjest\ViewComponents\Data\OperationsCollection;
use Nayjest\ViewComponents\Data\ProcessingServices\ArrayProcessingService;
use Nayjest\ViewComponents\Data\ProcessorResolvers\ArrayProcessorResolver;
use PHPUnit_Framework_TestCase;

class ArrayProcessingServiceTest extends AbstractProcessingServiceTest
{
    public function setUp()
    {
        $this->data = include FIXTURES_DIR . '/users.php';
        $this->operations = new OperationsCollection();
        $this->service = new ArrayProcessingService(
            new ArrayProcessorResolver(),
            $this->operations,
            $this->data
        );
        $this->totalCount = count($this->data);
    }
}