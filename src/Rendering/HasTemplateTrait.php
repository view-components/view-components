<?php
namespace ViewComponents\ViewComponents\Rendering;

/**
 * Trait HasTemplateTrait
 *
 * Implements HasTemplateInterface
 *
 */
trait HasTemplateTrait
{

    protected $template;

    protected $theme;

    /**
     * @param string $theme
     * @return $this
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * @param string $template
     * @return $this
     */
    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Returns template name considering used theme.
     *
     * @return string
     */
    public function resolveTemplate()
    {
        if (strpos($this->template, '*') !== false) {
            return str_replace('*', $this->getTheme(), $this->template);
        }
        return $this->template;
    }
}
