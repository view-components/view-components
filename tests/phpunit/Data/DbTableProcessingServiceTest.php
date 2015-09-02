<?php

namespace Presentation\Framework\Test\Data;

use Presentation\Framework\Data\DbTable\Query;
use Presentation\Framework\Data\OperationsCollection;
use Presentation\Framework\Data\ProcessingService\DbTableProcessingService;
use Presentation\Framework\Data\ProcessorResolver\DbTableProcessorResolver;
use PDO;
use PHPUnit_Framework_TestCase;

class DbTableProcessingServiceTest extends AbstractProcessingServiceTest
{
    public function setUp()
    {
        $this->data = new Query(
            \Presentation\Framework\Demo\db_connection(),
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