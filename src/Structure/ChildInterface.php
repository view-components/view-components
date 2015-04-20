<?php
namespace Nayjest\ViewComponents\Structure;

/**
 * Interface ChildInterface
 * @package Nayjest\ViewComponents
 */
interface ChildInterface
{
    /**
     * Attaches component to parent.
     *
     * @param ParentInterface $parent
     * @return null
     */
    public function internalSetParent(ParentInterface $parent);

    public function internalUnsetParent();

    /**
     * Returns parent object.
     *
     * @return ParentInterface|null
     */
    public function getParent();

    /**
     * @param callable $condition
     * @return ParentInterface|ChildInterface|null
     */
    public function findClosestParent($condition);
}
