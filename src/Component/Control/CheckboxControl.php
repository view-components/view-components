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

    public function isManualFormSubmitRequired()
    {
        return true;
    }

    public function setView(ViewComponentInterface $view = null)
    {
        parent::setView($view);
        $this->setViewData();
        return $this;
    }

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
