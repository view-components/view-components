<?php

namespace ViewComponents\ViewComponents\Component\Control;

use ViewComponents\ViewComponents\Component\Container;
use ViewComponents\ViewComponents\Component\Part;
use ViewComponents\ViewComponents\Base\Control\ControlInterface;
use ViewComponents\ViewComponents\Component\TemplateView;
use ViewComponents\ViewComponents\Input\InputOption;
use ViewComponents\ViewComponents\Data\Operation\DummyOperation;
use ViewComponents\ViewComponents\Data\Operation\SortOperation;

class SortingSelectControl extends Part implements ControlInterface
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

    /**
     * SortingSelectControl constructor.
     *
     * @param string[] $fields
     * @param InputOption $fieldOption
     * @param InputOption $directionOption
     */
    public function __construct(
        array $fields,
        InputOption $fieldOption,
        InputOption $directionOption
    ) {
        $this->fields = $fields;
        $this->fieldOption = $fieldOption;
        $this->directionOption = $directionOption;
        parent::__construct($this->makeDefaultView(), 'sorting_select', 'control_container');
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

    private function validateInput()
    {
        return $this->fieldOption->hasValue()
        && array_key_exists(
            $this->fieldOption->getValue(),
            $this->fields
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
        return new Container([
            new TemplateView(
                'select',
                [
                    'label' => 'Sorting',
                    'inline' => 'true',
                    'name' => $this->getFieldOption()->getKey(),
                    'value' => $this->getFieldOption()->getValue(),
                    'options' => $this->getFields(),
                ]
            ),
            new TemplateView(
                'select',
                [
                    'inline' => 'true',
                    'name' => $this->getDirectionOption()->getKey(),
                    'value' => $this->getDirectionOption()->getValue(),
                    'options' => [
                        SortOperation::ASC => 'Asc.',
                        SortOperation::DESC => 'Desc.',
                    ],
                ]
            )
        ]);
    }
}
