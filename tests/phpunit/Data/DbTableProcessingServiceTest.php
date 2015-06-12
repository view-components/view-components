<?php

namespace Nayjest\ViewComponents\Test\Data;

use Nayjest\ViewComponents\Data\DbTable\Query;
use Nayjest\ViewComponents\Data\OperationsCollection;
use Nayjest\ViewComponents\Data\ProcessingServices\DbTableProcessingService;
use Nayjest\ViewComponents\Data\ProcessorResolvers\DbTableProcessorResolver;
use PDO;
use PHPUnit_Framework_TestCase;

class DbTableProcessingServiceTest extends AbstractProcessingServiceTest
{
    public function setUp()
    {
        $this->data = new Query(
            \Nayjest\ViewComponents\Demo\db_connection(),
            'users'
        );
        $this->operations = new OperationsCollection();
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