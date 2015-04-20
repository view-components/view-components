<?php
namespace Nayjest\ViewComponents\Rendering;

/**
 * Interface ViewInterface
 * @package Nayjest\ViewComponents\Rendering
 */
interface TemplatedViewInterface extends ViewInterface
{
    /**
     * Returns template.
     *
     * @return string|null
     */
    public function getTemplate();

    /**
     * Sets template.
     *
     * @param string $template
     * @return $this
     */
    public function setTemplate($template);

    public function getTheme();

    /**
     * @param $theme
     * @return mixed
     */
    public function setTheme($theme);
}
