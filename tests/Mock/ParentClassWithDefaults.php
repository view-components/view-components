<?php
namespace Nayjest\ViewComponents\Test\Mock;

use Nayjest\ViewComponents\Structure\ParentInterface;
use Nayjest\ViewComponents\Structure\ParentTrait;

class ParentClassWithDefaults implements ParentInterface {
    use ParentTrait;

    protected function defaultComponents()
    {
        return [
            new ChildClass,
            new ChildClass,
        ];
    }
}
