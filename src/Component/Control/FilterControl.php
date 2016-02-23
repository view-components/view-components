<?php

namespace ViewComponents\ViewComponents\Component\Control;

use ViewComponents\ViewComponents\Base\Control\ControlInterface;
use ViewComponents\ViewComponents\Component\TemplateView;
use ViewComponents\ViewComponents\Component\Part;
use ViewComponents\ViewComponents\Data\DataAcceptorInterface;
use ViewComponents\ViewComponents\Data\Operation\DummyOperation;
use ViewComponents\ViewComponents\Data\Operation\FilterOperation;
use ViewComponents\ViewComponents\Input\InputOption;
use Stringy\StaticStringy;


class FilterControl extends Part implements ControlInterface
{
    /** @var string */
    private $field;

    /** @var string */
    private $operator;

    /** @var InputOption */
    private $valueOption;

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
        $this->valueOption = $input;
        parent::__construct(
            $this->makeDefaultView(),
            $this->field . '_filter' . rand(0, PHP_INT_MAX),
            'control_container'
        );
    }

    public function isManualFormSubmitRequired()
    {
        return true;
    }

    public function getValue()
    {
        return $this->valueOption->getValue();
    }

    public function getOperation()
    {
        if (!$this->valueOption->hasValue()) {
            return new DummyOperation();
        }
        return new FilterOperation(
            $this->field,
            $this->operator,
            $this->getValue()
        );
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }

    protected function makeDefaultView()
    {
        return new TemplateView('controls/filter');
    }

    protected function setViewData()
    {
        $view  = $this->getView();
        if (!$view instanceof DataAcceptorInterface) {
            return;
        }
        $view->setData([
            'name' => $this->valueOption->getKey(),
            'label' => StaticStringy::humanize($this->field),
            'value' => $this->valueOption->getValue()
        ]);
    }

    public function render()
    {
        $this->setViewData();
        return parent::render();
    }
}
