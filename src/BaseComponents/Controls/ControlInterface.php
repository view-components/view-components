<?php
namespace Nayjest\ViewComponents\BaseComponents\Controls;

use Nayjest\ViewComponents\Data\Actions\Base\ActionInterface;
use Nayjest\ViewComponents\BaseComponents\ComponentInterface;

/**
 * Interface ControlInterface
 *
 * Controls can provide actions that accepts input and affects on data provider.
 *
 */
interface ControlInterface extends ComponentInterface
{
    /**
     * @return ActionInterface
     */
    public function getAction();
}
