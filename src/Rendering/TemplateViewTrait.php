<?php
namespace Nayjest\ViewComponents\Rendering;

use Nayjest\ViewComponents\Structure\ChildNodeTrait;

/**
 * Trait TemplateViewTrait
 *
 * Implements TemplateViewInterface
 *
 */
trait TemplateViewTrait
{
    use ChildNodeTrait;
    use ViewTrait;

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

    private function isTemplatedView($object)
    {
        return $object instanceof TemplateViewInterface;
    }

    protected function resolveTheme()
    {
        if ($this->getTheme() !== null) {
            return $this->getTheme();
        }
        /**
         * @var TemplateViewInterface|null $parent
         */
        $parent = $this->findClosestParent([$this, 'isTemplatedView']);
        if ($parent !== null) {
            return $parent->getTheme();
        }
        return null;
    }

    public function setTemplate()
    {
        return $this->template;
    }

    protected function getTemplate()
    {
        return $this->template;
    }

    /**
     * Returns name of view template.
     *
     * @return string
     */
    protected function resolveTemplate()
    {
        if (strpos($this->template, '*') !== false) {
            return str_replace('*', $this->resolveTheme(), $this->template);
        }
        return $this->template;
    }

    protected function getViewData()
    {
        return ['component' => $this];
    }
}
