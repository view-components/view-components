<?php
namespace Presentation\Framework\Base;

use Traversable;

/**
 * Interface RepeaterInterface
 *
 */
interface RepeaterInterface extends ComponentInterface
{
    /**
     * Sets data source to iterate over.
     *
     * @param array|Traversable $iterator
     * @return $this
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
     * @return $this
     */
    public function setCallback($callback);
}
