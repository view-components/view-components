<?php
namespace Presentation\Framework\BaseComponents;

use Presentation\Framework\Rendering\ViewInterface;
use Presentation\Framework\Structure\ChildNodeInterface;

interface ComponentInterface extends
    ViewInterface,
    ChildNodeInterface
{
}
