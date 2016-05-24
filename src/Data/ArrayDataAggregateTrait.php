<?php
namespace ViewComponents\ViewComponents\Data;

trait ArrayDataAggregateTrait
{
    use DataAggregateTrait;

    /**
     * Merges new data if possible.
     *
     * @param array|object $data
     * @param bool $overridePrevious
     * @return $this
     */
    public function mergeData($data, $overridePrevious = true)
    {
        $oldData = $this->getData();
        if ($oldData === null) {
            $oldData = [];
        }
        if (is_object($data)) {
            $data = get_object_vars($data);
        }
        $this->setData($overridePrevious ? array_merge($oldData, $data) : array_merge($data, $oldData));
        return $this;
    }

    public function setDefaultData($data)
    {
        $this->mergeData($data, false);
        return $this;
    }

    public function setDataItem($key, $value)
    {
        $this->mergeData([$key => $value]);
        return $this;
    }

    public function hasDataKey($key)
    {
        return array_key_exists($key, $this->getData());
    }

    public function getDataItem($key, $default = null)
    {
        $data = $this->getData();
        return array_key_exists($key, $data) ? $data[$key] : $default;
    }
}
