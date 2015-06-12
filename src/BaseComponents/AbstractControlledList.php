<?php
namespace Nayjest\ViewComponents\BaseComponents;

use Nayjest\ViewComponents\BaseComponents\Controls\ControlInterface;
use Nayjest\ViewComponents\BaseComponents\Controls\ControlTrait;
use Nayjest\ViewComponents\Components\Repeater;
use Nayjest\ViewComponents\Data\Actions\ActionSet;
use Nayjest\ViewComponents\Data\Actions\Base\ActionInterface;
use Nayjest\ViewComponents\Data\DataProviderInterface;
use Nayjest\ViewComponents\Data\RepeaterInterface;
use Nayjest\ViewComponents\Rendering\ViewInterface;

abstract class AbstractControlledList implements
    ViewInterface,
    ContainerInterface,
    ControlInterface
{
    use ContainerTrait;
    use ControlTrait;

    /** @var ControlInterface[] */
    protected $controls;
    protected $itemView;
    protected $provider;
    /** @var  RepeaterInterface|ComponentInterface */
    protected $repeater;

    abstract protected function createComponentsTree();

    /**
     * @param ComponentInterface $itemView
     * @param ComponentInterface[]|ControlInterface[] $controls
     * @param DataProviderInterface $provider
     */
    public function __construct(
        ComponentInterface $itemView,
        array $controls = [],
        DataProviderInterface $provider
    )
    {
        $this->itemView = $itemView;
        $this->controls = $controls;
        $this->provider = $provider;
        $this->createActionSet();
        $this->createRepeater();
        $this->createComponentsTree();

    }

    protected function createRepeater()
    {
        $this->repeater = new Repeater(
            $this->provider,
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
    }

    /**
     * @return RepeaterInterface|ComponentInterface
     */
    public function getRepeater()
    {
        return $this->repeater;
    }

    /**
     * @return array|Controls\ControlInterface[]
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

    public function applyInput(array $input)
    {
        $this->getAction()->apply($this->provider, $input);
    }
}
