<?php

namespace ViewComponents\ViewComponents\Component;

use Nayjest\Tree\ChildNodeTrait;
use ViewComponents\ViewComponents\Base\DataViewComponentInterface;
use ViewComponents\ViewComponents\Data\DataAggregateTrait;
use ViewComponents\ViewComponents\Rendering\ViewTrait;

/**
 * This component renders custom data as JSON
 */
class Json implements DataViewComponentInterface
{
    use ChildNodeTrait;
    use ViewTrait;
    use DataAggregateTrait;
    protected $options;

    /**
     * Constructor.
     *
     * @param $data
     * @param int|null $options
     */
    public function __construct(
        $data = null,
        $options = JSON_PRETTY_PRINT
    ) {
        $this->setData($data);
        $this->options = $options;
    }

    /**
     * Renders component and returns output (string with json).
     *
     * @return string
     */
    public function render()
    {
        return json_encode($this->getData(), $this->options);
    }

    /**
     * Returns options of json_encode command.
     * @see json_encode
     *
     * @return int
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Sets options of json_encode command.
     * @see json_encode
     *
     * @param int $options
     * @return $this
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }
}
