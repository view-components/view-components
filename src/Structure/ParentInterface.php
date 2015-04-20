<?php
namespace Nayjest\ViewComponents\Structure;

/**
 * Interface ParentInterface
 * @package Nayjest\ViewComponents
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
