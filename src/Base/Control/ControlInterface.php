<?php
namespace ViewComponents\ViewComponents\Base\Control;

use ViewComponents\ViewComponents\Base\Compound\PartInterface;
use ViewComponents\ViewComponents\Data\Operation\OperationInterface;

interface ControlInterface extends PartInterface
{
    /**
     * Creates operation.
     *
     * @return OperationInterface
     */
    public function getOperation();

    /**
     * This method is used by root component (e.g. ManagedList)
     * to determine that submit button should be present.
     *
     * @see \ViewComponents\ViewComponents\Component\ManagedList::hideSubmitButtonIfNotUsed
     *
     * @return bool
     */
    public function isManualFormSubmitRequired();
}
