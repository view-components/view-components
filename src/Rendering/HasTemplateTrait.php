<?php
namespace Nayjest\ViewComponents\Rendering;


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

//    private function isTemplatedView($object)
//    {
//        return $object instanceof HasTemplateInterface;
//    }

//    protected function resolveTheme()
//    {
//        if ($this->getTheme() !== null) {
//            return $this->getTheme();
//        }
//        /**
//         * @var HasTemplateInterface|null $parent
//         */
//        $parent = $this->findClosestParent([$this, 'isTemplatedView']);
//        if ($parent !== null) {
//            return $parent->getTheme();
//        }
//        return null;
//    }

    /**
     * @param string $template
     * @return $this
     */
    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    protected function getTemplate()
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
//
//    protected function getViewData()
//    {
//        return ['component' => $this];
//    }
}
