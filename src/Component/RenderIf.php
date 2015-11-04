<?php

namespace Presentation\Framework\Component;

use Presentation\Framework\Base\AbstractComponent;

class RenderIf extends AbstractComponent
{

    protected $condition;

    /**
     * RenderIf constructor.
     * @param array $children
     * @param callable|null $condition
     */
    public function __construct(array $children = [], callable $condition = null)
    {
        $this->setChildren($children);
        $this->setCondition($condition);
    }

    /**
     * @return string
     */
    public function render()
    {
        return $this->isRenderingRequired() ? parent::render() : '';
    }

    /**
     * Returns true if component will be rendered.
     *
     * @return bool
     */
    public function isRenderingRequired()
    {
        if (is_callable($this->getCondition())) {
            return call_user_func($this->getCondition(), $this);
        }
        return true;
    }

    /**
     * @return callable|null
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @param callable|null $condition
     */
    public function setCondition($condition)
    {
        $this->condition = $condition;
    }
}
