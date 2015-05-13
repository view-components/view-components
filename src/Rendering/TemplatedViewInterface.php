<?php
namespace Nayjest\ViewComponents\Rendering;

/**
 * Interface ViewInterface
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

    /**
     * @return string|null
     */
    public function getTheme();

    /**
     * @param string $theme
     * @return $this
     */
    public function setTheme($theme);
}
