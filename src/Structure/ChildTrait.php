<?php
namespace Nayjest\ViewComponents\Structure;

/**
 * Class ChildTrait
 *
 * @implements ChildInterface
 *
 */
trait ChildTrait
{
    /**
     * @internal
     * @var ParentInterface|ChildInterface
     * */
    private $parent;

    /**
     * Attaches component to registry.
     *
     * @param ParentInterface $parent
     * @return null
     */
    final public function internalSetParent(ParentInterface $parent)
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
     * @return ParentInterface|null
     */
    final public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param callable $condition
     * @return ParentInterface|ChildInterface|null
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
