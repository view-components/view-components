<?php
namespace Presentation\Framework\Base;

use Nayjest\Tree\NodeInterface;
use Presentation\Framework\Rendering\ViewInterface;

interface ComponentInterface extends NodeInterface, ViewInterface
{
    public function renderChildren();
}
