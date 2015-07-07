<?php
namespace Presentation\Framework\Structure;

/**
 * Interface ParentNodeInterface
 *
 * Interface of parent node in the tree data structure.
 *
 */
interface ParentNodeInterface
{
    /**
     * Returns collection of attached components.
     *
     * @return NodesCollection
     */
    public function components();
}
