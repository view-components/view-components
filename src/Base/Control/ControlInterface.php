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
     * @return bool
     */
    public function isManualFormSubmitRequired();
}
