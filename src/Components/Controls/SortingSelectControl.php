<?php

namespace Presentation\Framework\Components\Controls;

use Presentation\Framework\BaseComponents\ContainerInterface;
use Presentation\Framework\BaseComponents\Controls\ControlInterface;
use Presentation\Framework\BaseComponents\ViewComponentAggregateTrait;
use Presentation\Framework\Common\InputOption;
use Presentation\Framework\Components\Controls\View\SortingSelectView;
use Presentation\Framework\Data\Operations\DummyOperation;
use Presentation\Framework\Data\Operations\SortOperation;

class SortingSelectControl implements ControlInterface, ContainerInterface
{
    use ViewComponentAggregateTrait;
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
     * @param array $fields
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
