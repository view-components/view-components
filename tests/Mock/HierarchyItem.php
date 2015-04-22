<?php
namespace Nayjest\ViewComponents\Test\Mock;

use Nayjest\ViewComponents\Structure\ChildInterface;
use Nayjest\ViewComponents\Structure\ChildTrait;
use Nayjest\ViewComponents\Structure\ParentInterface;
use Nayjest\ViewComponents\Structure\ParentTrait;

class HierarchyItem implements ParentInterface, ChildInterface
{
    use ParentTrait;
    use ChildTrait;
}
