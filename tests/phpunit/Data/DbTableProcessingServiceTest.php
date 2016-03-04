<?php

namespace ViewComponents\ViewComponents\Test\Data;

use ViewComponents\ViewComponents\Data\DbTable\Query;
use ViewComponents\ViewComponents\Data\OperationCollection;
use ViewComponents\ViewComponents\Data\ProcessingService\DbTableProcessingService;
use ViewComponents\ViewComponents\Data\ProcessorResolver\DbTableProcessorResolver;
use PDO;

class DbTableProcessingServiceTest extends AbstractProcessingServiceTest
{
    public function setUp()
    {
        $this->data = new Query(
            \ViewComponents\TestingHelpers\dbConnection(),
            'test_users'
        );
        $this->operations = new OperationCollection();
        $this->service = new DbTableProcessingService(
            new DbTableProcessorResolver(),
            $this->operations,
            $this->data
        );

        $q = clone $this->data;
        $q->select = 'count(*)';
        $s = $q->execute();
        $this->totalCount =  (int)$s->fetch(PDO::FETCH_NUM)[0];
    }
}