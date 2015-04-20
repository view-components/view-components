<?php
namespace Nayjest\ViewComponents\Rendering;

/**
 * Interface ViewInterface
 * @package Nayjest\ViewComponents\Rendering
 */
interface ViewInterface
{
    /**
     * Renders view.
     *
     * @return string
     */
    public function render();

    /**
     * Returns rendering result  when object is treated like a string.
     *
     * @return mixed
     */
    public function __toString();
}
