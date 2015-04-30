<?php
namespace Nayjest\ViewComponents\Test\Mock;

use Nayjest\ViewComponents\Structure\ChildNodeInterface;
use Nayjest\ViewComponents\Structure\ChildNodeTrait;
use Nayjest\ViewComponents\Structure\ParentNodeInterface;
use Nayjest\ViewComponents\Structure\ParentNodeTrait;

class HierarchyItem implements ParentNodeInterface, ChildNodeInterface
{
    use ParentNodeTrait;
    use ChildNodeTrait;
}
