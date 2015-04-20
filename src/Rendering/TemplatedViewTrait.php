<?php
namespace Nayjest\ViewComponents\Rendering;

use Illuminate\Support\Facades\View;

use Nayjest\ViewComponents\Structure\ChildInterface;
use Nayjest\ViewComponents\Structure\ChildTrait;
use Nayjest\ViewComponents\Structure\ParentInterface;

trait TemplatedViewTrait
{
    use ChildTrait;
    use ViewTrait;

    protected $template;

    protected $theme;

    public function setTheme($theme)
    {
        $this->theme = $theme;
        return $this;
    }

    public function getTheme()
    {
        return $this->theme;
    }

    private function isTemplatedView($object)
    {
        return $object instanceof TemplatedViewInterface;
    }

    protected function resolveTheme()
    {
        if ($this->getTheme() !== null) {
            return $this->getTheme();
        }
        /**
         * @var ParentInterface|ChildInterface|TemplatedViewInterface $parent
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

    /**
     * Renders object.
     *
     * @return string
     */
    public function render()
    {
        return View::make(
            $this->resolveTemplate(),
            $this->getViewData()
        )->render();
    }
}
