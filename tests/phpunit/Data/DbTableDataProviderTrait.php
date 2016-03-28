<?php

namespace ViewComponents\ViewComponents\Test\Data;

use ViewComponents\ViewComponents\Data\DataProviderInterface;
use ViewComponents\ViewComponents\Data\DbTableDataProvider;

trait DbTableDataProviderTrait
{
    /** @var DataProviderInterface  */
    protected $provider;

    /**
     * @return DataProviderInterface|DbTableDataProvider
     */
    protected function getDataProvider()
    {
        if (!$this->provider) {
            $this->provider = new DbTableDataProvider(
                \ViewComponents\TestingHelpers\dbConnection(),
                'test_users'
            );
        }
        return $this->provider;
    }
}
