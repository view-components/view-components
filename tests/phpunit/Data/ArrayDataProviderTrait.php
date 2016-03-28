<?php

namespace ViewComponents\ViewComponents\Test\Data;

use ViewComponents\TestingHelpers\Test\DefaultFixture;
use ViewComponents\ViewComponents\Data\ArrayDataProvider;
use ViewComponents\ViewComponents\Data\DataProviderInterface;

trait ArrayDataProviderTrait
{
    /** @var DataProviderInterface  */
    protected $provider;

    /**
     * @return ArrayDataProvider|DataProviderInterface
     */
    protected function getDataProvider()
    {
        if (!$this->provider) {
            $this->provider = new ArrayDataProvider(DefaultFixture::getArray());
        }
        return $this->provider;
    }
}
