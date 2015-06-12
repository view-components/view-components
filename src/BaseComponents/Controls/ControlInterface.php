<?php
namespace Nayjest\ViewComponents\BaseComponents\Controls;

use Nayjest\ViewComponents\Data\DataProviderInterface;
use Nayjest\ViewComponents\BaseComponents\ComponentInterface;

/**
 * Interface ControlInterface
 *
 * Controls can accept input and affect on data provider.
 *
 */
interface ControlInterface extends ComponentInterface
{
    public function initialize(DataProviderInterface $provider, array $input);
}
