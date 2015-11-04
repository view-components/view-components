<?php

namespace Presentation\Framework\Component;

use Presentation\Framework\Base\ComponentInterface;

class ConditionalCompoundContainer extends CompoundContainer
{

    protected $condition;

    /**
     * RenderIf constructor.
     * @param ComponentInterface|null $targetComponent
     * @param callable|null $condition
     */
    public function __construct(ComponentInterface $targetComponent, callable $condition = null)
    {
        parent::__construct(
            [
                'target' => []
            ],
            [
                'target' => $targetComponent
            ],
            'target'
        );
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
            return call_user_func($this->getCondition(), $this->getTerminalNode());
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
