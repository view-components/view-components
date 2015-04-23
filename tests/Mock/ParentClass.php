<?php
namespace Nayjest\ViewComponents\Test\Mock;

use Nayjest\ViewComponents\Structure\ParentNodeInterface;
use Nayjest\ViewComponents\Structure\ParentNodeTrait;

class ParentClass implements ParentNodeInterface {
    use ParentNodeTrait;
}
