<?php
namespace Nayjest\ViewComponents\BaseComponents;

use Nayjest\ViewComponents\Rendering\ChildViewInterface;
use Nayjest\ViewComponents\Rendering\ViewInterface;
use Nayjest\ViewComponents\Structure\ChildInterface;

interface ComponentInterface extends
    ViewInterface,
    ChildInterface,
    ChildViewInterface
{
}
