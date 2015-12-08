<?php

namespace Presentation\Framework\Initialization;

use Presentation\Framework\Base\ComponentInterface;

interface InitializableInterface
{
    public function initialize(ComponentInterface $initializer);
}
