<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.06.2015
 * Time: 22:20
 */

namespace Nayjest\ViewComponents\BaseComponents;


use Nayjest\ViewComponents\BaseComponents\Controls\ControlInterface;
use Nayjest\ViewComponents\Components\Repeater;
use Nayjest\ViewComponents\Data\DataProviderInterface;
use Nayjest\ViewComponents\Data\RepeaterInterface;
use Nayjest\ViewComponents\Rendering\ViewInterface;


abstract class AbstractControlledList implements
    ViewInterface,
    ContainerInterface
{
    const GROUP_CONTROLS = 'controls';

    use ContainerTrait;

    /** @var ControlInterface[] */
    protected $controls;
    protected $itemView;
    protected $provider;
    /** @var  RepeaterInterface|ComponentInterface */
    protected $repeater;

    abstract protected function createComponentsTree();

    public function __construct(
        ComponentInterface $itemView,
        array $controls = []
    ) {
        $this->itemView = $itemView;
        $this->controls = $controls;
        $this->createRepeater();
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

    protected function setDataProvider(DataProviderInterface $provider)
    {
        $this->provider = $provider;
        $this->repeater->setIterator($provider);
    }

    public function initialize(DataProviderInterface $provider, array $input)
    {
        $this->setDataProvider($provider);
        foreach($this->controls as $control)
        {
            $control->initialize($this->provider, $input);
        }
    }
}