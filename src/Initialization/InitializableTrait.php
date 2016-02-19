<?php

namespace ViewComponents\ViewComponents\Initialization;

use ViewComponents\ViewComponents\Base\ComponentInterface;
use RuntimeException;

trait InitializableTrait
{
    private $initializer;

    public function initialize(ComponentInterface $initializer)
    {
        $this->initializer = $initializer;
    }

    /**
     * @return ComponentInterface|null
     */
    protected function getInitializer()
    {
        return $this->initializer;
    }

    /**
     * @return ComponentInterface
     */
    protected function requireInitializer()
    {
        if ($this->initializer == null) {
            throw new RuntimeException(
                static::class . ' expects root component able perform initialization.'
            );
        }
        return $this->initializer;
    }

}
