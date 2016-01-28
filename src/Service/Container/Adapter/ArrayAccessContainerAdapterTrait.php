<?php

namespace Presentation\Framework\Service\Container\Adapter;

use ArrayAccess;
use Presentation\Framework\Service\Container\Exception\NotFoundException;

/**
 * Trait ArrayAccessContainerTrait
 */
trait ArrayAccessContainerAdapterTrait
{
    /**
     * @return ArrayAccess|array
     */
    abstract public function getContainer();

    public function get($id)
    {
        if (!$this->has($id)) {
            throw new NotFoundException;
        }
        $container = $this->getContainer();
        return $container[$id];
    }

    public function has($id)
    {
        $container = $this->getContainer();
        return isset($container[$id]);
    }
}
