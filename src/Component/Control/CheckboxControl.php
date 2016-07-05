<?php

namespace ViewComponents\ViewComponents\Component\Control;

use ViewComponents\ViewComponents\Base\Control\ControlInterface;
use ViewComponents\ViewComponents\Base\ViewComponentInterface;
use ViewComponents\ViewComponents\Component\TemplateView;
use ViewComponents\ViewComponents\Component\Part;
use ViewComponents\ViewComponents\Data\Operation\DummyOperation;
use ViewComponents\ViewComponents\Data\Operation\OperationInterface;
use ViewComponents\ViewComponents\Input\InputOption;

class CheckboxControl extends Part implements ControlInterface
{
    protected $inputOption;
    protected $operation;
    protected $label;

    /**
     * CheckboxControl constructor.
     *
     * @param OperationInterface $operation
     * @param InputOption $inputOption
     * @param string|null $label
     */
    public function __construct(
        OperationInterface $operation,
        InputOption $inputOption,
        $label = null
    ) {
        $this->label = $label;
        $this->inputOption = $inputOption;
        $this->operation = $operation;
        parent::__construct(
            $this->makeDefaultView(),
            'checkbox_' . rand(0, PHP_INT_MAX),
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
     * @param ViewComponentInterface|null $view
     * @return $this
     */
    public function setView(ViewComponentInterface $view = null)
    {
        parent::setView($view);
        $this->setViewData();
        return $this;
    }

    /**
     * @return OperationInterface|DummyOperation
     */
    public function getOperation()
    {
        if (!$this->inputOption->hasValue()) {
            return new DummyOperation();
        }
        return $this->operation;
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
                'data-control' => 'checkbox',
            ],
            'inline' => true,
            'label' => $this->label,
            'name' => $this->inputOption->getKey(),
            'inputAttributes' => [
                'type' => 'checkbox',
                'value' => '1',
            ]
        ];
        if ($this->inputOption->hasValue()) {
            $defaults['inputAttributes']['checked'] = 'checked';
        }
        $view->setDefaultData($defaults);
    }
}
