<?php

namespace Presentation\Framework\Service\Container\Adapter;

/**
 * Class PimpleContainerAdapter.
 * PimpleContainerAdapter is an adapter for using pimple/pimple v1.X container with presentation framework.
 */
class PimpleContainerAdapter extends AbstractContainerAdapter
{
    use ArrayAccessContainerAdapterTrait;

    /**
     * @param string $id
     * @param callable $callback
     * @return $this
     */
    public function set($id, callable $callback)
    {
        /** @var \Pimple\Pimple $container */
        $container = $this->container;
        $container[$id] = $container->share(function() use($callback) {
            return call_user_func($callback, $this);
        });
    }

    /**
     * @param string $id
     * @param callable $callback
     * @return $this
     */
    public function extend($id, callable $callback)
    {
        /** @var \Pimple\Pimple $container */
        $container = $this->container;
        $container->extend($id, function ($inst) use ($callback) {
            return call_user_func($callback, $inst, $this);
        });
    }
}