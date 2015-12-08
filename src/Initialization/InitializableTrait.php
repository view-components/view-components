<?php

namespace Presentation\Framework\Initialization;

use Presentation\Framework\Base\ComponentInterface;
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

    protected function requireInitializer()
    {
        if ($this->initializer == null) {
            throw new RuntimeException(
                static::class . ' expects root component that can perform initialization.'
            );
        }
        return $this->initializer;
    }

}
