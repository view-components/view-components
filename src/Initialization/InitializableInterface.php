<?php

namespace ViewComponents\ViewComponents\Initialization;

use ViewComponents\ViewComponents\Base\ComponentInterface;

interface InitializableInterface
{
    public function initialize(ComponentInterface $initializer);
}
