<?php

namespace Presentation\Framework\Test\Data;

use Presentation\Framework\Data\OperationsCollection;
use Presentation\Framework\Data\ProcessingServices\ArrayProcessingService;
use Presentation\Framework\Data\ProcessorResolvers\ArrayProcessorResolver;
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