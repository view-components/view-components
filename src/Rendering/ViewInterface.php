<?php
namespace ViewComponents\ViewComponents\Rendering;

/**
 * Interface ViewInterface
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
     * @return string
     */
    public function __toString();
}
