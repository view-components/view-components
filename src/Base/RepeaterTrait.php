<?php
namespace Presentation\Framework\Base;

use Traversable;

trait RepeaterTrait
{
    /** @var array|Traversable */
    protected $iterator;

    /** @var  callable */
    protected $callback;

    /**
     * Sets data source to iterate over.
     *
     * @param array|Traversable $iterator
     * @return $this
     */
    public function setIterator($iterator)
    {
        $this->iterator = $iterator;
        return $this;
    }

    /**
     * Returns iterated data source.
     *
     * @return array|Traversable
     */
    public function getIterator()
    {
        return $this->iterator;
    }

    /**
     * Sets iteration callback.
     *
     * Callback will be executed on each iteration
     * with repeater instance passed to first argument and iterated data element
     * passed to second argument.
     *
     * @param callable $callback arguments: repeater, iterated element
     * @return mixed
     */
    public function setCallback($callback)
    {
        $this->callback = $callback;
        return $this;
    }

    public function getCallback()
    {
        return $this->callback;
    }
}
