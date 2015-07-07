<?php
namespace Presentation\Framework\Components;

use Presentation\Framework\BaseComponents\AbstractItemView;

class Json extends AbstractItemView
{
    protected $options = JSON_PRETTY_PRINT;

    /**
     * @param null $data
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

    public function render()
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
