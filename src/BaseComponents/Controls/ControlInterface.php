<?php
namespace Nayjest\ViewComponents\BaseComponents\Controls;

use Nayjest\ViewComponents\Data\Operations\OperationInterface;

interface ControlInterface
{
    /**
     * @return OperationInterface
     */
    public function getOperation();
}
