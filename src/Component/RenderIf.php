<?php

namespace Presentation\Framework\Component;

use Presentation\Framework\Base\AbstractComponent;
use Presentation\Framework\Base\ComponentInterface;

class RenderIf extends AbstractComponent
{

    protected $condition;

    /**
     * RenderIf constructor.
     * @param callable|null $condition
     * @param array|ComponentInterface[] $children
     */
    public function __construct(callable $condition = null, array $children = [])
    {
        $this->setChildren($children);
        $this->setCondition($condition);

    }

    /**
     * Returns true if component will be rendered.
     *
     * @return bool
     */
    public function isVisible()
    {
        if (is_callable($this->getCondition())) {
            return call_user_func($this->getCondition(), $this) && parent::isVisible();
        }
        return parent::isVisible();
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
