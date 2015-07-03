<?php

namespace Nayjest\ViewComponents\Components\Controls;

use Nayjest\ViewComponents\BaseComponents\ContainerInterface;
use Nayjest\ViewComponents\BaseComponents\Controls\ControlInterface;
use Nayjest\ViewComponents\BaseComponents\ViewComponentAggregateTrait;
use Nayjest\ViewComponents\Common\InputValueReader;
use Nayjest\ViewComponents\Components\Controls\FilterControl\FilterControlView;
use Nayjest\ViewComponents\Data\Operations\DummyOperation;
use Nayjest\ViewComponents\Data\Operations\FilterOperation;
use Stringy\StaticStringy;

class FilterControl implements ControlInterface, ContainerInterface
{
    use ViewComponentAggregateTrait;

    /** @var string */
    protected $field;

    /** @var string */
    protected $operator;

    /** @var InputValueReader */
    protected $input;

    /**
     * @param string $field
     * @param string $operator
     * @param InputValueReader $input
     */
    public function __construct(
        $field,
        $operator = FilterOperation::OPERATOR_EQ,
        InputValueReader $input = null
    )
    {
        $this->field = $field;
        $this->operator = $operator;
        $this->input = $input;
    }

    public function getOperation()
    {
        if (!$this->input->hasValue()) {
            return new DummyOperation();
        }
        return new FilterOperation(
            $this->field,
            $this->operator,
            $this->input->getValue()
        );
    }

    protected function makeDefaultView()
    {
        return new FilterControlView(
            $this->input->getKey(),
            $this->input->getValue(),
            StaticStringy::humanize($this->field)
        );
    }

}
