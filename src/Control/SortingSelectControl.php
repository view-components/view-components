<?php

namespace Presentation\Framework\Control;

use Presentation\Framework\Input\InputOption;
use Presentation\Framework\Component\ControlView\SortingSelectView;
use Presentation\Framework\Data\Operation\DummyOperation;
use Presentation\Framework\Data\Operation\SortOperation;

class SortingSelectControl implements ControlInterface
{
    use ControlTrait;
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
     * @param array $fields list of fields allowed to sort (<name> => <Label>)
     * @param InputOption $fieldOption
     * @param InputOption $directionOption
     */
    public function __construct(
        array $fields,
        InputOption $fieldOption,
        InputOption $directionOption
    )
    {

        $this->fields = $fields;
        $this->fieldOption = $fieldOption;
        $this->directionOption = $directionOption;
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

    protected function makeDefaultView()
    {
        return new SortingSelectView($this);
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
}
