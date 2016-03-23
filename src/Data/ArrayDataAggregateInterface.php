<?php

namespace ViewComponents\ViewComponents\Data;

interface ArrayDataAggregateInterface extends DataAggregateInterface
{
    public function mergeData($data, $overridePrevious = true);

    public function setDefaultData($data);
}
