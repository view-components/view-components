<?php
namespace Presentation\Framework\Control;

use Presentation\Framework\Base\ComponentInterface;
use Presentation\Framework\Data\Operation\OperationInterface;

interface ControlInterface
{
    /**
     * Creates operation.
     *
     * @return OperationInterface
     */
    public function getOperation();

    /**
     * @return ComponentInterface
     */
    public function getView();
}