<?php
namespace Nayjest\ViewComponents\BaseComponents;

use Nayjest\ViewComponents\Structure\ParentInterface;
use Nayjest\ViewComponents\Rendering\ParentViewInterface;

interface ContainerInterface extends
    ComponentInterface,
    ParentViewInterface,
    ParentInterface
{
}
