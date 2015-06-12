<?php

namespace Nayjest\ViewComponents\Components\Controls;

use Nayjest\ViewComponents\BaseComponents\ContainerInterface;
use Nayjest\ViewComponents\BaseComponents\Controls\ControlInterface;
use Nayjest\ViewComponents\BaseComponents\Controls\ControlTrait;
use Nayjest\ViewComponents\BaseComponents\ViewComponentAggregateTrait;
use Nayjest\ViewComponents\Components\Html\Tag;
use Nayjest\ViewComponents\Components\Text;
use Nayjest\ViewComponents\Data\DataProviderInterface;
use Nayjest\ViewComponents\Data\Operations\Filter as FilterOperation;

class Filter implements ControlInterface, ContainerInterface
{
    use ViewComponentAggregateTrait;
    use ControlTrait;

    protected $label;

    protected function applyOperations(DataProviderInterface $provider)
    {
        $this->filterOperation->setValue(
            $this->inputValueReader->getValue()
        );
        $provider->operations()->add($this->filterOperation);
    }

    /**
     * @param string $field
     * @param string $operator
     * @param mixed|null $default
     */
    public function __construct(
        $field,
        $operator = FilterOperation::OPERATOR_EQ,
        $default = null
    )
    {
        $this->filterOperation = new FilterOperation($field, $operator);
        $this->makeInputValueReader($field, $default);
        $this->setLabel($field);
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    public function getInputName()
    {
        return $this->inputValueReader->getInputKey();
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
            new Tag('input', [
                'value' => $this->inputValueReader->getValue(),
                'type' => 'text',
                'name' => $this->getInputName(),
                'id' => $this->getInputId()
            ]),
            new Text('&nbsp;')
        ]);
        return $container;
    }
}
