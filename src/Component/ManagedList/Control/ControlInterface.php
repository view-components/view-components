<?php
namespace Presentation\Framework\Component\ManagedList\Control;

use Presentation\Framework\Base\ComponentInterface;
use Presentation\Framework\Data\Operation\OperationInterface;

interface ControlInterface extends ComponentInterface
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
