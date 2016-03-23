<?php
namespace ViewComponents\ViewComponents\Data;

trait DataAggregateTrait
{
    private $data;

    /**
     * Sets custom data.
     *
     * @param $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Returns data.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}
