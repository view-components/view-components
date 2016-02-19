<?php
namespace ViewComponents\ViewComponents\Base;

use Nayjest\Collection\Extended\ObjectCollectionInterface;
use ViewComponents\ViewComponents\Rendering\ViewInterface;

/**
 * In addition to renderable component facilities (RenderableComponentTrait), can have children.
 */
trait RenderChildrenTrait
{

    /** @return ObjectCollectionInterface */
    abstract public function children();

    public function renderChildren()
    {
        $output = '';
        /** @var ViewInterface $child */
        foreach ($this->getChildrenForRendering() as $child) {
            $output .= $child->render();
        }
        return $output;
    }

    protected function getChildrenForRendering()
    {
        return $this->children()->filterByType(ViewInterface::class);
    }
}
