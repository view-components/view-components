<?php
namespace Presentation\Framework\Test\Mock;

use Presentation\Framework\Structure\ParentNodeInterface;
use Presentation\Framework\Structure\ParentNodeTrait;

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
