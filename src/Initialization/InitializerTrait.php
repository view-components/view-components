<?php

namespace ViewComponents\ViewComponents\Initialization;

use Nayjest\Tree\Utils;

trait InitializerTrait
{
    protected function startInitialization()
    {
        $callback = function(InitializableInterface $component) {
            $component->initialize($this);
        };
        Utils::applyCallback($callback, $this, InitializableInterface::class);
    }

    protected function initializeCollection(array $items)
    {
        parent::initializeCollection($items);
        $this->startInitialization();
    }
}
