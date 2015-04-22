<?php
namespace Nayjest\ViewComponents\Structure;

/**
 * Interface ParentInterface
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
