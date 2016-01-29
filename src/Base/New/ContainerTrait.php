<?php
namespace Presentation\Framework\Base;

use Nayjest\Collection\Extended\ObjectCollectionInterface;
use Presentation\Framework\Rendering\ViewInterface;

trait ContainerTrait
{
    use ViewComponentTrait;

    /** @return ObjectCollectionInterface */
    abstract public function children();

    private $isChildrenRenderedInside;

    private $isSortingEnabled = true;

    public function renderChildren()
    {
        $output = '';
        /** @var ComponentInterface $child */
        foreach ($this->getChildrenForRendering() as $child) {
            $output .= $child->render();
        }
        return $output;
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

    final protected function doRender()
    {
        $this->isChildrenRenderedInside = false;
        $output = $this->renderContainer();
        if ($this->isChildrenRenderedInside === false) {
            $output .= $this->renderChildren();
        }
        return $output;
    }

    /**
     * Basic implementation just renders children.
     * It's a good candidate for overriding.
     *
     * @return string
     */
    protected function renderContainer()
    {
        return $this->renderChildren();
    }
}
