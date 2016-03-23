<?php
namespace ViewComponents\ViewComponents\Data;

interface DataAggregateInterface
{
    /**
     * Sets custom data.
     *
     * @param $data
     * @return $this
     */
    public function setData($data);

    /**
     * Returns custom data.
     *
     * @return mixed
     */
    public function getData();
}
