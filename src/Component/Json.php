<?php

namespace ViewComponents\ViewComponents\Component;

use Nayjest\Tree\ChildNodeTrait;
use ViewComponents\ViewComponents\Base\DataViewComponentInterface;
use ViewComponents\ViewComponents\Common\HasDataTrait;
use ViewComponents\ViewComponents\Rendering\ViewTrait;

class Json implements DataViewComponentInterface
{
    use ChildNodeTrait;
    use ViewTrait;
    use HasDataTrait;
    protected $options;

    /**
     * @param $data
     * @param int|null $options
     */
    public function __construct(
        $data = null,
        $options = JSON_PRETTY_PRINT
    )
    {
        $this->setData($data);
        $this->options = $options;
    }

    public function render()
    {
        return json_encode($this->getData(), $this->options);
    }

    /**
     * @return int
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param int $options
     * @return $this
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }
}
