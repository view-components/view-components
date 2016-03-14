<?php
namespace ViewComponents\ViewComponents\Data;

use RuntimeException;

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

    /**
     * Merges new data if possible.
     *
     * @param array $data
     * @return $this
     */
    public function mergeData($data)
    {
        $oldData = $this->getData();
        if ($oldData === null) {
            $this->setData($data);
            return $this;
        }
        if (is_object($data)) {
            $data = get_object_vars($data);
        }
        if (is_object($oldData)) {
            \mp\setValues($oldData, $data, MP_USE_SETTERS | MP_CREATE_PROPERTIES);
            $this->setData($oldData);
            return $this;
        }
        if (is_array($oldData)) {
            $this->setData(array_merge($oldData, $data));
            return $this;
        }
        throw new RuntimeException('Can\'t merge non-array data');
    }
}
