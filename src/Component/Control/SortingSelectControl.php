<?php

namespace ViewComponents\ViewComponents\Component\Control;

use ViewComponents\ViewComponents\Component\CompoundPart;
use ViewComponents\ViewComponents\Base\Control\ControlInterface;
use ViewComponents\ViewComponents\Component\TemplateView;
use ViewComponents\ViewComponents\Data\DataAcceptorInterface;
use ViewComponents\ViewComponents\Input\InputOption;
use ViewComponents\ViewComponents\Data\Operation\DummyOperation;
use ViewComponents\ViewComponents\Data\Operation\SortOperation;

class SortingSelectControl extends CompoundPart implements ControlInterface
{
    /**
     * @var string[]
     */
    private $fields;
    /**
     * @var InputOption
     */
    private $fieldOption;
    /**
     * @var InputOption
     */
    private $directionOption;

    public function __construct(
        array $fields,
        InputOption $fieldOption,
        InputOption $directionOption
    )
    {
        $this->fields = $fields;
        $this->fieldOption = $fieldOption;
        $this->directionOption = $directionOption;
        parent::__construct($this->makeDefaultView(), 'sorting_select', 'control_container');
    }

    public function isManualFormSubmitRequired()
    {
        return true;
    }

    public function getOperation()
    {
        if (!$this->validateInput()) {
            return new DummyOperation();
        }
        return new SortOperation(
            $this->fieldOption->getValue(),
            $this->directionOption->getValue()
        );
    }

    /**
     * @return InputOption
     */
    public function getFieldOption()
    {
        return $this->fieldOption;
    }

    /**
     * @return InputOption
     */
    public function getDirectionOption()
    {
        return $this->directionOption;
    }

    /**
     * @return string[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    public function render()
    {
        $this->setViewData();
        return parent::render();
    }

    private function validateInput()
    {
        return $this->fieldOption->hasValue()
        && array_key_exists(
            $this->fieldOption->getValue(), $this->fields
        )
        && $this->directionOption->hasValue()
        && in_array(
            $this->directionOption->getValue(),
            [SortOperation::ASC, SortOperation::DESC],
            true
        );
    }

    protected function makeDefaultView()
    {
        return new TemplateView('controls/sorting_select');
    }

    protected function setViewData()
    {
        $view  = $this->getView();
        if (!$view instanceof DataAcceptorInterface) {
            return;
        }
        $view->setData([
            'fields' => $this->fields,
            'fieldSelectName' => $this->getFieldOption()->getKey(),
            'directionSelectName' => $this->getDirectionOption()->getKey(),
            'selectedDirection' => $this->getDirectionOption()->getValue(),
            'selectedField' => $this->getFieldOption()->getValue()
        ]);
    }
}
