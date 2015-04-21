<?php
namespace Nayjest\ViewComponents\BaseComponents;

use Nayjest\ViewComponents\Rendering\ChildViewInterface;
use Nayjest\ViewComponents\Rendering\ChildViewTrait;
use Nayjest\ViewComponents\Rendering\ViewTrait;
use Nayjest\ViewComponents\Rendering\ViewInterface;
use Nayjest\ViewComponents\Structure\ChildInterface;
use Nayjest\ViewComponents\Structure\ChildTrait;

abstract class Component implements ViewInterface, ChildInterface, ChildViewInterface
{
    use ChildTrait;
    use ViewTrait;
    use ChildViewTrait;

    abstract public function render();
}