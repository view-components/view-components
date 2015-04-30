<?php
namespace Nayjest\ViewComponents\Test\Mock;

use Nayjest\ViewComponents\Structure\ParentNodeInterface;
use Nayjest\ViewComponents\Structure\ParentNodeTrait;

class ParentClassWithDefaults implements ParentNodeInterface {
    use ParentNodeTrait;

    protected function defaultComponents()
    {
        return [
            new ChildClass,
            new ChildClass,
        ];
    }
}
