<?php
namespace Nayjest\ViewComponents\Rendering;

trait ChildViewTrait
{
    protected $renderSection;

    /**
     * @param $section
     * @return $this
     */
    public function setRenderSection($section)
    {
        $this->renderSection = $section;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRenderSection()
    {
        return $this->renderSection;
    }
}
