<?php
namespace Nayjest\ViewComponents\Test\Mock;

use Nayjest\ViewComponents\Structure\ChildNodeInterface;
use Nayjest\ViewComponents\Structure\ChildNodeTrait;

class ChildClass implements ChildNodeInterface
{
    use ChildNodeTrait;
}
