<?php

namespace ViewComponents\ViewComponents\Customization\CssFrameworks\Bootstrap;

class ViewHelper
{
    public $baseButtonClass;
    public $buttonSizeClass;
    public $defaultButtonStyleClass;

    public $baseTableClass;
    public $tableSizeClass;
    public $defaultTableStyleClass;

    public $baseInputClass;
    public $defaultInputStyleClass;
    public $inputSizeClass;

    /**
     * Constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        \mp\setValues($this, $config, null);
    }

    public function getTableClasses($styleClass = null)
    {
        return $this->getClasses('table', $styleClass);
    }

    public function getInputClasses($styleClass = null)
    {
        return $this->getClasses('input', $styleClass);
    }

    public function getButtonClasses($styleClass = null)
    {
        return $this->getClasses('button', $styleClass);
    }

    protected function getClasses($component, $styleClass = null)
    {
        $ucComponent = ucfirst($component);
        $styleClass = ($styleClass === null) ? $this->{"default{$ucComponent}StyleClass"} : $styleClass;
        return join(' ', [
            $this->{"base{$ucComponent}Class"},
            $this->{"{$component}SizeClass"},
            $styleClass,
        ]);
    }
}
