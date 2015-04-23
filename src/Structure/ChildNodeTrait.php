<?php
namespace Nayjest\ViewComponents\Structure;

/**
 * Class ChildNodeTrait
 *
 * @implements ChildNodeInterface
 *
 */
trait ChildNodeTrait
{
    /**
     * @internal
     * @var ParentNodeInterface|ChildNodeInterface
     * */
    private $parent;

    /**
     * Attaches component to registry.
     *
     * @param ParentNodeInterface $parent
     * @return null
     */
    final public function internalSetParent(ParentNodeInterface $parent)
    {
        $this->parent = $parent;
    }

    final public function internalUnsetParent()
    {
        $this->parent = null;
    }

    /**
     * Returns parent object.
     *
     * @return ParentNodeInterface|null
     */
    final public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param callable $condition
     * @return ParentNodeInterface|ChildNodeInterface|null
     */
    final public function findClosestParent($condition)
    {
        if ($this->parent === null) {
            return null;
        }
        if (call_user_func($condition, $this->parent)) {
            return $this->parent;
        } else {
            return $this->parent->findClosestParent($condition);
        }
    }
}
