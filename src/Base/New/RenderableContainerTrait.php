<?php
namespace Presentation\Framework\Base;

use Nayjest\Collection\Extended\ObjectCollectionInterface;
use Presentation\Framework\Rendering\ViewInterface;

/**
 * In addition to renderable component facilities (RenderableComponentTrait), can have children.
 */
trait RenderableContainerTrait
{
    use AdvancedViewTrait {
        AdvancedViewTrait::prepareForRender as prepareForRenderBasic();
        AdvancedViewTrait::finalizeRender as finalizeRenderBasic();
    }

    /** @return ObjectCollectionInterface */
    abstract public function children();

    private $isChildrenRenderedInside;

    final public function renderChildren()
    {
        $output = '';
        /** @var ComponentInterface $child */
        foreach ($this->getChildrenForRendering() as $child) {
            $output .= $child->render();
        }
        return $output;
    }

    protected function sortsChildren()
    {
        return true;
    }

    protected function getChildrenForRendering()
    {
        $views = $this->children()->filterByType(ViewInterface::class);
        return $this->sortsChildren() ? $views->sortByProperty('sortPosition') : $views;
    }

    protected function prepareForRender()
    {
        $this->isChildrenRenderedInside = false;
        return $this->prepareForRenderBasic();
    }

    protected function finalizeRender($output)
    {
        if ($this->isChildrenRenderedInside === false) {
            $output .= $this->renderChildren();
        }
        return $this->finalizeRenderBasic($output);
    }
}
