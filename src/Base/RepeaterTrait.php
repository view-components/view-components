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
     * with iterated data element passed to first argument and repeater instance
     * passed to second argument.
     *
     * @param callable $callback arguments: iterated element, repeater
     * @return mixed
     */
    public function setCallback(callable $callback = null)
    {
        $this->callback = $callback;
        return $this;
    }

    /**
     * Returns iteration callback.
     *
     * @return callable arguments: iterated element, repeater
     */
    public function getCallback()
    {
        return $this->callback;
    }
}
