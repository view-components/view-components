<?php

namespace Nayjest\ViewComponents\Components\Controls;

use Nayjest\ViewComponents\BaseComponents\ContainerInterface;
use Nayjest\ViewComponents\BaseComponents\Controls\ControlInterface;
use Nayjest\ViewComponents\BaseComponents\ViewComponentAggregateTrait;
use Nayjest\ViewComponents\Common\InitializedOnceTrait;
use Nayjest\ViewComponents\Components\Container;
use Nayjest\ViewComponents\Components\Html\Tag;
use Nayjest\ViewComponents\Components\Text;
use Nayjest\ViewComponents\Data\DataProviderInterface;
use Nayjest\ViewComponents\Data\Operations\Filter as FilterOperation;

class Filter implements ControlInterface, ContainerInterface
{
    use ViewComponentAggregateTrait;
    use InitializedOnceTrait;

    protected $default;

    protected $inputValue;

    protected $inputKey;

    protected $inputName;

    /** @var Filter */
    protected $operation;

    protected $label;

    public function __construct(
        $field,
        $operator = FilterOperation::OPERATOR_EQ,
        $default = null
    )
    {
        $this->operation = new FilterOperation();
        $this->setField($field);
        $this->setLabel($field);
        $this->setOperator($operator);
        $this->setDefault($default);
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

    /**
     * @return Filter
     */
    public function getOperation()
    {
        return $this->operation;
    }

    public function setOperator($operator)
    {
        $this->operation->setOperator($operator);
        return $this;
    }

    public function getOperator()
    {
        return $this->operation->getOperator();
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->operation->getField();
    }

    /**
     * @param string $field
     * @return $this
     */
    public function setField($field)
    {
        $this->operation->setField($field);
        return $this;
    }

    public function getInputName()
    {
        return $this->inputName ?: $this->getInputKey();
    }

    /**
     * @param string $inputName
     * @return $this
     */
    public function setInputName($inputName)
    {
        $this->inputName = $inputName;
        return $this;
    }

    public function initialize(DataProviderInterface $provider, array $input)
    {
        $this->setInitialized();
        $this->initializeInputValue($input);

        if ($this->hasValue()) {
            $this->operation->setValue($this->getValue());
            $provider->operations()->add($this->operation);
        }
    }

    /**
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setDefault($value)
    {
        $this->default = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInputKey()
    {
        return $this->inputKey ?: $this->getField();
    }

    /**
     * @param string $inputKey
     */
    public function setInputKey($inputKey)
    {
        $this->inputKey = $inputKey;
    }

    /**
     * @return mixed
     */
    public function getInputValue()
    {
        $this->checkInitialized();
        return $this->inputValue;
    }

    public function getValue()
    {
        return $this->hasInputValue()
            ? $this->getInputValue()
            : $this->getDefault();
    }

    public function hasInputValue()
    {
        $this->checkInitialized();
        return $this->inputValue !== null && $this->inputValue !== '';
    }

    public function hasDefaultValue()
    {
        $default = $this->getDefault();
        return $default !== null && $default !== '';
    }

    public function hasValue()
    {
        return $this->hasInputValue() || $this->hasDefaultValue();
    }

    protected function initializeInputValue($input)
    {
        if (array_key_exists(
            $this->getInputKey(),
            $input
        )) {
            $this->inputValue = $input[$this->getInputKey()];
        }
    }

    /**
     * @return \Nayjest\ViewComponents\Rendering\ViewInterface
     */
    protected function makeDefaultView()
    {
        return new Container([
            new Tag('label', [
                'for' => $this->getInputName()
            ], [
                new Text($this->getLabel())
            ]),
            new Tag('input', [
                'value' => $this->getValue(),
                'name' => $this->getInputName()
            ])
        ]);
    }
}
