<?php

namespace ViewComponents\ViewComponents\Test\Storage;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionMethod;
use ViewComponents\ViewComponents\Storage\DbTableStorage;

class DbTableStorageTest extends AbstractStorageTest
{
    /** @var  DbTableStorage */
    protected $storage;

    public function setUp()
    {
        $this->dropTable();
        $this->storage = new DbTableStorage(
            $this->connection(),
            'view_components_storage_test',
            'id',
            'data',
            true
        );
    }

    public function tearDown()
    {
        $this->dropTable();
    }

    /**
     * @return \PDO
     */
    protected function connection()
    {
        return \ViewComponents\TestingHelpers\dbConnection();
    }

    protected function dropTable()
    {
        $this->connection()->exec('DROP TABLE IF EXISTS view_components_storage_test');
    }

    /**
     * @param $name
     * @return ReflectionMethod
     */
    protected static function getStorageMethod($name)
    {
        $class = new ReflectionClass(DbTableStorage::class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }

    public function testTable()
    {
        $this->dropTable();
        $exists = $this->getStorageMethod('tableExists');
        self::assertFalse($exists->invoke($this->storage));

        $create = $this->getStorageMethod('createTable');
        $create->invoke($this->storage);
        self::assertTrue($exists->invoke($this->storage));
    }
}