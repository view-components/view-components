<?php
namespace Nayjest\ViewComponents\BaseComponents;

use Nayjest\ViewComponents\Structure\ParentNodeInterface;
use Nayjest\ViewComponents\Rendering\ParentViewInterface;

interface ContainerInterface extends
    ComponentInterface,
    ParentViewInterface,
    ParentNodeInterface
{
}
