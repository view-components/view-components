<?php
namespace Nayjest\ViewComponents\Rendering;

/**
 * Interface ViewInterface
 */
interface ParentViewInterface extends ViewInterface
{
    /**
     * @param string|null $section
     * @return string
     */
    public function renderComponents($section = null);
}
