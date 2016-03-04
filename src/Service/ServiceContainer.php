<?php

namespace ViewComponents\ViewComponents\Service;

use Interop\Container\ContainerInterface;

/**
 * Simple service container implementation.
 *
 * This class is used by presentation framework as default service container.
 */
class ServiceContainer implements ContainerInterface
{
    protected $callbacks = [];
    protected $instances = [];

    /**
     * Defines service.
     *
     * @param $id
     * @param callable $callback accepts container as first argument
     */
    public function set($id, callable $callback)
    {
        if ($this->has($id)) {
            throw new Exception\AlreadyExistsException;
        }
        $this->callbacks[$id] = $callback;
    }

    /**
     * Returns true if service exists.
     *
     * @param string $id
     * @return bool
     */
    public function has($id)
    {
        return array_key_exists($id, $this->callbacks);
    }

    /**
     * Returns specified service.
     * Throws exception if requested service not exists.
     *
     * @param string $id
     * @return mixed
     */
    public function get($id)
    {
        if (!$this->has($id)) {
            throw new Exception\NotFoundException;
        }
        if (!$this->isReady($id)) {
            $this->instantiate($id);
        }
        return $this->instances[$id];
    }

    /**
     * Extends existing service.
     *
     * @param string $id
     * @param callable $callback accepts extended service instance as first argument and container as second
     * @return $this
     */
    public function extend($id, callable $callback)
    {
        if (!$this->has($id)) {
            throw new Exception\NotFoundException;
        }
        $oldCallback = $this->callbacks[$id];
        $this->callbacks[$id] = function () use ($oldCallback, $callback, $id) {
            if (!$this->isReady($id)) {
                $thisFunction = $this->callbacks[$id];
                $this->callbacks[$id] = $oldCallback;
                $this->instantiate($id);
                $this->callbacks[$id] = $thisFunction;
            }
            $instance = $this->instances[$id];
            $newInstance = call_user_func($callback, $instance, $this);
            return $newInstance ?: $instance;
        };
        if ($this->isReady($id)) {
            $instance = $this->instances[$id];
            $newInstance = call_user_func($callback, $instance, $this);
            $this->instances[$id] = $newInstance ?: $instance;
        }
        return $this;
    }

    /**
     * Instantiates specified service.
     *
     * @param string $id
     */
    protected function instantiate($id)
    {
        $this->instances[$id] = call_user_func($this->callbacks[$id], $this);
    }

    /**
     * Returns true if service already instantiated.
     *
     * @param string $id
     * @return bool
     */
    protected function isReady($id)
    {
        return array_key_exists($id, $this->instances);
    }
}
