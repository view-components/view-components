<?php

namespace Nayjest\ViewComponents\Test\Data;

use Nayjest\ViewComponents\Data\ArrayProcessingManager;
use Nayjest\ViewComponents\Data\OperationsCollection;
use Nayjest\ViewComponents\Data\ProcessorResolvers\ArrayProcessorResolver;
use PHPUnit_Framework_TestCase;

class ArrayProcessingManagerTest extends AbstractProcessingManagerTest
{
    public function setUp()
    {
        $this->data = include FIXTURES_DIR . '/users.php';
        $this->operations = new OperationsCollection();
        $this->manager = new ArrayProcessingManager(
            new ArrayProcessorResolver(),
            $this->operations,
            $this->data
        );
        $this->totalCount = count($this->data);
    }
}