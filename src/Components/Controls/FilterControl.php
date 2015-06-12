<?php

namespace Nayjest\ViewComponents\Components\Controls;

use Nayjest\ViewComponents\BaseComponents\ContainerInterface;
use Nayjest\ViewComponents\BaseComponents\Controls\ControlInterface;
use Nayjest\ViewComponents\BaseComponents\Controls\ControlTrait;
use Nayjest\ViewComponents\BaseComponents\ViewComponentAggregateTrait;
use Nayjest\ViewComponents\Components\Html\Tag;
use Nayjest\ViewComponents\Components\Text;
use Nayjest\ViewComponents\Data\Actions\FilterAction;

class FilterControl implements ControlInterface, ContainerInterface
{
    use ViewComponentAggregateTrait;
    use ControlTrait;

    protected $label;


    /**
     * @param FilterAction $action
     * @param string|null $label
     */
    public function __construct(
        FilterAction $action,
        $label = null
    )
    {
        $this->action = $action;
        $this->setLabel($label);
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string|null $label
     * @return $this
     */
    protected function setLabel($label)
    {
        if ($label === null) {
            $label = ucfirst(
                $this->action->getInputValueReader()->getInputKey()
            );
        }
        $this->label = $label;
        return $this;
    }

    public function getInputName()
    {
        return $this->action->getInputValueReader()->getInputKey();
    }

    public function getInputId()
    {
        return $this->getInputName() . '_input';
    }

    /**
     * @return \Nayjest\ViewComponents\Rendering\ViewInterface
     */
    protected function makeDefaultView()
    {
        $container = new Tag('span');
        $container->setAttribute('data-role','control-container');
        $container->components()->set([
            new Tag('label', [
                'for' => $this->getInputId()
            ], [
                new Text($this->getLabel())
            ]),
            new Text('&nbsp;'),
            new Tag('input', [
                'value' => $this->action->getInputValueReader()->getValue(),
                'type' => 'text',
                'name' => $this->getInputName(),
                'id' => $this->getInputId()
            ]),
            new Text('&nbsp;')
        ]);
        return $container;
    }
}
