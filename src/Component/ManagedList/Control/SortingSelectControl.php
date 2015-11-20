<?php

namespace Presentation\Framework\Component\ManagedList\Control;

use Presentation\Framework\Base\CompoundPartInterface;
use Presentation\Framework\Base\CompoundPartTrait;
use Presentation\Framework\Base\ViewAggregate;
use Presentation\Framework\Component\CompoundComponent;
use Presentation\Framework\Input\InputOption;
use Presentation\Framework\Component\ManagedList\Control\View\SortingSelectView;
use Presentation\Framework\Data\Operation\DummyOperation;
use Presentation\Framework\Data\Operation\SortOperation;

class SortingSelectControl  extends ViewAggregate implements ControlInterface, CompoundPartInterface
{
    use CompoundPartTrait;

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
     * @param CompoundComponent $root
     * @return string|null
     */
    public function resolveParentName(CompoundComponent $root)
    {
        return 'control_container';
    }

    public function getComponentName()
    {
        return $this->componentName ?: 'sorting_select_' . rand();
    }

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
        parent::__construct(new SortingSelectView($this));
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
