<?php

namespace Presentation\Framework\Component;

use Presentation\Framework\Base\AbstractDataView;

class CustomDataView extends AbstractDataView
{
    /**
     * @var callable
     */
    private $renderer;

    public function __construct(callable $renderer)
    {
        $this->renderer = $renderer;
        parent::__construct();
    }

    public function renderData()
    {
        return call_user_func($this->renderer, $this->getData());
    }
}
