<?php

namespace Presentation\Framework\Components\Controls;

use Presentation\Framework\BaseComponents\ContainerInterface;
use Presentation\Framework\BaseComponents\Controls\ControlInterface;
use Presentation\Framework\BaseComponents\ViewComponentAggregateTrait;
use Presentation\Framework\Common\InputOption;
use Presentation\Framework\Components\Controls\FilterControl\FilterControlView;
use Presentation\Framework\Data\Operations\DummyOperation;
use Presentation\Framework\Data\Operations\FilterOperation;
use Stringy\StaticStringy;

class FilterControl implements ControlInterface, ContainerInterface
{
    use ViewComponentAggregateTrait;

    /** @var string */
    protected $field;

    /** @var string */
    protected $operator;

    /** @var InputOption */
    protected $input;

    /**
     * @param string $field
     * @param string $operator
     * @param InputOption $input
     */
    public function __construct(
        $field,
        $operator = FilterOperation::OPERATOR_EQ,
        InputOption $input
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
