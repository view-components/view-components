<?php
namespace Nayjest\ViewComponents\BaseComponents;

use Nayjest\ViewComponents\Rendering\ViewInterface;
use Nayjest\ViewComponents\Structure\ChildNodeInterface;

interface ComponentInterface extends
    ViewInterface,
    ChildNodeInterface
{
    public function getRenderSection();

    public function setRenderSection($section);
}
