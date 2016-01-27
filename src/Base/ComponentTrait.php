<?php
namespace Presentation\Framework\Base;

use Nayjest\Collection\Extended\ObjectCollectionInterface;
use Presentation\Framework\Rendering\ViewInterface;

trait ComponentTrait
{
    abstract public function on($event, callable $listener);
    abstract public function emit($event, array $arguments = []);

    protected $componentName;

    protected $sortPosition = 1;

    protected $isSortingEnabled = true;

    protected $visible = true;

    /** @return ObjectCollectionInterface */
    abstract public function children();

    public function renderChildren()
    {
        $output = '';
        /** @var ComponentInterface $child */
        foreach ($this->getChildrenForRendering() as $child) {
            $output .= $child->render();
        }
        return $output;
    }

    public function render()
    {
        $this->emit('render', [$this]);
        if (!$this->isVisible()) {
            return '';
        }
        return $this->renderChildren();
    }

    /**
     * @return string|null
     */
    public function getComponentName()
    {
        if (!$this->componentName) {
            $parts = explode('\\', static::class);
            $baseName = array_pop($parts);
            $this->componentName = $baseName . '_' . rand();
        }
        return $this->componentName;
    }

    /**
     * @param string|null $componentName
     * @return $this
     */
    public function setComponentName($componentName)
    {
        $this->componentName = $componentName;
        return $this;
    }

    /**
     * @return int
     */
    public function getSortPosition()
    {
        return $this->sortPosition;
    }

    /**
     * @param int $sortPosition
     * @return $this
     */
    public function setSortPosition($sortPosition)
    {
        $this->sortPosition = $sortPosition;
        return $this;
    }

    /**
     * @param bool $value
     */
    public function setSortable($value = true)
    {
        $this->isSortingEnabled = $value;
    }

    /**
     * @return bool
     */
    public function isSortable()
    {
        return $this->isSortingEnabled;
    }


    protected function getChildrenForRendering()
    {
        $views = $this->children()->filterByType(ViewInterface::class);
        return $this->isSortingEnabled ? $views->sortByProperty('sortPosition') : $views;
    }

    public function onRender(callable $callback)
    {
        $this->on('render', $callback);
        return $this;
    }

    public function hide()
    {
        $this->visible = false;
        return $this;
    }

    public function show()
    {
        $this->visible = true;
        return $this;
    }

    public function setVisible($value)
    {
        $this->visible = $value;
        return $this;
    }

    public function isVisible()
    {
        return $this->visible;
    }
}
