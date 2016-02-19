<?php
namespace ViewComponents\ViewComponents\Base\Control;

use ViewComponents\ViewComponents\Base\Compound\CompoundPartInterface;
use ViewComponents\ViewComponents\Data\Operation\OperationInterface;

interface ControlInterface extends CompoundPartInterface
{
    /**
     * Creates operation.
     *
     * @return OperationInterface
     */
    public function getOperation();

    /**
     * @return bool
     */
    public function isManualFormSubmitRequired();
}
