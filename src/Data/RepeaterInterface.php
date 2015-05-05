<?php
namespace Nayjest\ViewComponents\Data;

use Traversable;

/**
 * Interface RepeaterInterface
 *
 */
interface RepeaterInterface
{
    /**
     * Sets data source to iterate over.
     *
     * @param array|Traversable $iterator
     */
    public function setIterator($iterator);

    /**
     * Returns iterated data source.
     *
     * @return array|Traversable
     */
    public function getIterator();

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
    public function setCallback($callback);
}
