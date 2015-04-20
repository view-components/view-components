<?php
namespace Nayjest\ViewComponents\Rendering;

//use Nayjest\ViewComponents\Rendering\ViewTrait;

trait ChildViewTrait
{
    //use ViewTrait;

    protected $render_section;

    /**
     * @param $section
     * @return $this
     */
    public function setRenderSection($section)
    {
        $this->render_section = $section;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRenderSection()
    {
        return $this->render_section;
    }
}
