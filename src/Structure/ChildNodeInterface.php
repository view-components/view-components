<?php
namespace Presentation\Framework\Structure;

/**
 * Interface ChildNodeInterface
 *
 * Interface of terminal node in the tree data structure.
 *
 */
interface ChildNodeInterface
{
    /**
     * Attaches component to parent.
     *
     * @param ParentNodeInterface $parent
     */
    public function internalSetParent(ParentNodeInterface $parent);

    public function internalUnsetParent();

    /**
     * Returns parent object.
     *
     * @return ParentNodeInterface|null
     */
    public function getParent();

    /**
     * @param callable $condition
     * @return ParentNodeInterface|ChildNodeInterface|null
     */
    public function findClosestParent($condition);
}
