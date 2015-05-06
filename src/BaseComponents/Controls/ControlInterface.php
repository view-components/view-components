<?php
namespace Nayjest\ViewComponents\BaseComponents\Controls;

use Nayjest\ViewComponents\Data\DataProviderInterface;
use Nayjest\ViewComponents\BaseComponents\ComponentInterface;

interface ControlInterface extends ComponentInterface
{
    public function initialize(DataProviderInterface $provider, array $input);
}
