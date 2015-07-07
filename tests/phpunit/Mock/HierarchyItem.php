<?php
namespace Presentation\Framework\Test\Mock;

use Presentation\Framework\Structure\ChildNodeInterface;
use Presentation\Framework\Structure\ChildNodeTrait;
use Presentation\Framework\Structure\ParentNodeInterface;
use Presentation\Framework\Structure\ParentNodeTrait;

class HierarchyItem implements ParentNodeInterface, ChildNodeInterface
{
    use ParentNodeTrait;
    use ChildNodeTrait;
}
