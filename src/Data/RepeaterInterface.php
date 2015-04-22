<?php
namespace Nayjest\ViewComponents\Data;

/**
 * Interface RepeaterInterface
 *
 */
interface RepeaterInterface
{
    /**
     * Data source to iterate over.
     *
     * @param array|\Traversable $iterator
     */
    public function setIterator($iterator);

    /**
     * @param callable $callback
     * @return mixed
     */
    public function setCallback($callback);
}
