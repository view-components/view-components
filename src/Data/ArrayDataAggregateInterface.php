<?php

namespace ViewComponents\ViewComponents\Data;

interface ArrayDataAggregateInterface extends DataAggregateInterface
{
    public function mergeData($data, $overridePrevious = true);

    public function setDefaultData($data);

    public function getDataItem($key, $default = null);

    public function setDataItem($key, $value);

    public function hasDataKey($key);
}
