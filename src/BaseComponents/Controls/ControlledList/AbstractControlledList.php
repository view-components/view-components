<?php
namespace Nayjest\ViewComponents\BaseComponents\Controls\ControlledList;

use Nayjest\ViewComponents\BaseComponents\ComponentInterface;
use Nayjest\ViewComponents\BaseComponents\ContainerInterface;
use Nayjest\ViewComponents\BaseComponents\ContainerTrait;
use Nayjest\ViewComponents\BaseComponents\Controls\ControlInterface;
use Nayjest\ViewComponents\BaseComponents\Controls\ControlTrait;
use Nayjest\ViewComponents\Components\Repeater;
use Nayjest\ViewComponents\Data\Actions\ActionSet;
use Nayjest\ViewComponents\Data\Actions\Base\ActionInterface;
use Nayjest\ViewComponents\Data\RepeaterInterface;

abstract class AbstractControlledList implements
    ContainerInterface,
    ControlInterface
{
    use ContainerTrait;
    use ControlTrait;

    /** @var ControlInterface[] */
    protected $controls;
    protected $itemView;

    /** @var  RepeaterInterface|ComponentInterface */
    protected $repeater;

    abstract protected function createComponentsTree();

    /**
     * @param ComponentInterface $itemView
     * @param ComponentInterface[]|ControlInterface[] $controls
     */
    public function __construct(
        ComponentInterface $itemView,
        array $controls = []
    )
    {
        $this->itemView = $itemView;
        $this->controls = $controls;

        $this->createRepeater();
        $this->createActionSet();
        $this->createComponentsTree();

    }

    protected function createRepeater()
    {
        $this->repeater = new Repeater(
            null,
            [$this->itemView]
        );
    }

    /**
     * @return ActionInterface[]
     */
    private function extractChildActions()
    {

        $res = [];
        foreach ($this->controls as $control) {
            if ($control instanceof ControlInterface) {
                $res[] = $control->getAction();
            }
        }
        return $res;
    }

    protected function createActionSet()
    {
        $this->action = new ActionSet(
            $this->extractChildActions()
        );
        $this->action->after(
            new ControlledListHandler($this->repeater)
        );
    }

    /**
     * @return RepeaterInterface|ComponentInterface
     */
    public function getRepeater()
    {
        return $this->repeater;
    }

    /**
     * @return array|ControlInterface[]
     */
    public function getControls()
    {
        return $this->controls;
    }

    /**
     * @return ComponentInterface
     */
    public function getItemView()
    {
        return $this->itemView;
    }
}
