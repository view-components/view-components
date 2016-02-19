<?php
namespace ViewComponents\ViewComponents\Rendering;

/**
 * Interface HasTemplateInterface
 */
interface HasTemplateInterface
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

    /**
     * Returns template name considering used theme.
     *
     * @return string
     */
    public function resolveTemplate();
}
