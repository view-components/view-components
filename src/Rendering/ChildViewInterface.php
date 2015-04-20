<?php
namespace Nayjest\ViewComponents\Rendering;

interface ChildViewInterface extends ViewInterface
{
    public function getRenderSection();

    public function setRenderSection($section);
}
