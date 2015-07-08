<?php
namespace Presentation\Framework\BaseComponents\Controls;

use Presentation\Framework\Data\Operations\OperationInterface;

interface ControlInterface
{
    /**
     * Creates operation.
     *
     * @return OperationInterface
     */
    public function getOperation();
}
