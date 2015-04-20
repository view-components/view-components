<?php
namespace Nayjest\ViewComponents\Rendering;

/**
 * Interface ViewInterface
 * @package Nayjest\ViewComponents\Rendering
 */
interface ParentViewInterface extends ViewInterface
{
    /**
     * @param string|null $section
     * @return string
     */
    public function renderComponents($section = null);
}
