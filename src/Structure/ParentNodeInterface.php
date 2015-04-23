<?php
namespace Nayjest\ViewComponents\Structure;

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
     * @return Collection
     */
    public function components();

    public function setComponents(array $components = []);
}
