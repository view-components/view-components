<?php

namespace ViewComponents\ViewComponents\Base;

use Nayjest\Tree\NodeTrait;
use ViewComponents\ViewComponents\Rendering\ViewTrait;

trait ContainerComponentTrait
{
    use NodeTrait;
    use ViewTrait;
    use RenderChildrenTrait;
}
