<?php
namespace Presentation\Framework\Component;

use Presentation\Framework\Base\AbstractDataView;

class Json extends AbstractDataView
{
    protected $options = JSON_PRETTY_PRINT;

    /**
     * @param mixed $data
     * @param int $options
     */
    public function __construct(
        $data = null,
        $options = JSON_PRETTY_PRINT
    )
    {
        $this->options = $options;
        parent::__construct($data);
    }

    public function renderData()
    {
        return json_encode($this->data, $this->options);
    }

    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param $options
     * @return $this
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }
}
