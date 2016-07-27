<?php

namespace ViewComponents\ViewComponents\Component\Control;

use ViewComponents\ViewComponents\Base\Control\ControlInterface;
use ViewComponents\ViewComponents\Base\ViewComponentInterface;
use ViewComponents\ViewComponents\Component\TemplateView;
use ViewComponents\ViewComponents\Component\Part;
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
     * Constructor.
     *
     * @todo make inputOption second argument or provide default option based on field name
     *
     * @param string $field
     * @param string $operator
     * @param InputOption $input
     * @param $viewComponent
     */
    public function __construct(
        $field,
        $operator = FilterOperation::OPERATOR_EQ,
        InputOption $input = null,
        $viewComponent = null
    ) {
        $this->field = $field;
        $this->operator = $operator;
        $this->valueOption = $input;
        parent::__construct(
            $viewComponent ?: $this->makeDefaultView(),
            $this->field . '_filter' . rand(0, PHP_INT_MAX),
            'control_container'
        );
    }

    /**
     * This method is used by root component (e.g. ManagedList)
     * to determine that submit button should be present.
     *
     * @see \ViewComponents\ViewComponents\Component\ManagedList::hideSubmitButtonIfNotUsed
     *
     * @return bool
     */
    public function isManualFormSubmitRequired()
    {
        return true;
    }

    /**
     * Returns value from input or default value if input is not provided.
     *
     * @return mixed
     */
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

    public function setView(ViewComponentInterface $view = null)
    {
        parent::setView($view);
        $this->setViewData();
        return $this;
    }

    public function render()
    {
        $this->setViewData();
        return parent::render();
    }

    protected function makeDefaultView()
    {
        return new TemplateView('input');
    }

    protected function setViewData()
    {
        $view = $this->getView();
        if (!$view instanceof TemplateView) {
            return;
        }
        $defaults = [
            'containerAttributes' => [
                'data-role' => 'control-container',
                'data-control' => 'filter',
            ],
            'inline' => true,
            'label' => StaticStringy::humanize($this->field),
        ];
        if ($this->valueOption !== null) {
            $defaults['name'] = $this->valueOption->getKey();
            $defaults['value'] = $this->valueOption->getValue();
        }
        $view->setDefaultData($defaults);
    }
}
