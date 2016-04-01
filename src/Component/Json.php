<?php

namespace ViewComponents\ViewComponents\Component;

use Nayjest\Tree\ChildNodeTrait;
use ViewComponents\ViewComponents\Base\DataViewComponentInterface;
use ViewComponents\ViewComponents\Data\ArrayDataAggregateInterface;
use ViewComponents\ViewComponents\Data\ArrayDataAggregateTrait;
use ViewComponents\ViewComponents\Rendering\ViewTrait;

/**
 * The component for rendering custom data as JSON
 */
class Json implements DataViewComponentInterface, ArrayDataAggregateInterface
{
    use ChildNodeTrait;
    use ViewTrait;
    use ArrayDataAggregateTrait;

    protected $options;

    /**
     * Constructor.
     *
     * @param mixed $data data for encoding to JSON
     * @param int|null $options json_encode options
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
