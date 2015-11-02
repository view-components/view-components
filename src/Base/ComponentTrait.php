<?php
namespace Presentation\Framework\Base;

use Nayjest\Collection\Extended\ObjectCollectionInterface;

trait ComponentTrait
{
    abstract public function on($event, callable $listener);
    abstract public function emit($event, array $arguments = []);

    protected $componentName;

    protected $sortPosition = 1;

    protected $isSortingEnabled = true;

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
        return $this->renderChildren();
    }

    /**
     * @return string|null
     */
    public function getComponentName()
    {
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
        return $this->isSortingEnabled ? $this->children()->sortByProperty('sortPosition') : $this->children();
    }

    public function onRender(callable $callback)
    {
        $this->on('render', $callback);
        return $this;
    }
}
