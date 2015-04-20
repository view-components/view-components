<?php
namespace Nayjest\ViewComponents\Test\Mock;

use Nayjest\ViewComponents\Structure\ChildInterface;
use Nayjest\ViewComponents\Structure\ChildTrait;

class ChildClass implements ChildInterface
{
    use ChildTrait;
}
