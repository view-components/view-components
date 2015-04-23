<?php
namespace Nayjest\ViewComponents\Structure;

/**
 * Interface ParentInterface
 *
 * Interface of parent node in the tree data structure.
 *
 */
interface ParentInterface
{
    /**
     * Returns collection of attached components.
     *
     * @return Collection
     */
    public function components();

    public function setComponents(array $components = []);
}
