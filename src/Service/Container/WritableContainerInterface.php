<?php

namespace Presentation\Framework\Service\Container;

use Interop\Container\ContainerInterface;

interface WritableContainerInterface extends ContainerInterface
{
    /**
     * @param string $id
     * @param callable $callback
     * @return $this
     */
    public function set($id, callable $callback);

    /**
     * @param string $id
     * @param callable $callback
     * @return $this
     */
    public function extend($id, callable $callback);
}
