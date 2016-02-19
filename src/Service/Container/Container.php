<?php

namespace ViewComponents\ViewComponents\Service\Container;


use ViewComponents\ViewComponents\Service\Container\Exception\AlreadyExistsException;
use ViewComponents\ViewComponents\Service\Container\Exception\NotFoundException;

/**
 * Simple service container implementation.
 *
 * This class is used by presentation framework as default service container.
 */
class Container implements WritableContainerInterface
{
    protected $callbacks = [];
    protected $instances = [];

    public function set($id, callable $callback)
    {
        if ($this->has($id)) {
            throw new AlreadyExistsException;
        }
        $this->callbacks[$id] = $callback;
    }

    public function has($id)
    {
        return array_key_exists($id, $this->callbacks);
    }

    public function get($id)
    {
        if(!$this->has($id)) {
            throw new NotFoundException;
        }
        if (!$this->isReady($id)) {
            $this->instantiate($id);
        }
        return $this->instances[$id];
    }

    public function extend($id, callable $callback)
    {
        if (!$this->has($id)) {
            throw new NotFoundException;
        }
        if (!$this->isReady($id)) {
            $this->instantiate($id);
        }
        $instance = $this->instances[$id];
        unset($this->instances[$id]);
        $this->callbacks[$id] = function() use ($instance, $callback) {
            return call_user_func($callback, $instance, $this);
        };
        return $this;
    }

    protected function instantiate($id)
    {
        $this->instances[$id] = call_user_func($this->callbacks[$id], $this);
    }

    protected function isReady($id)
    {
        return array_key_exists($id, $this->instances);
    }
}
