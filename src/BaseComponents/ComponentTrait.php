<?php
namespace Nayjest\ViewComponents\BaseComponents;

use Nayjest\ViewComponents\Rendering\ViewTrait;
use Nayjest\ViewComponents\Structure\ChildNodeTrait;

trait ComponentTrait
{
    use ChildNodeTrait;
    use ViewTrait;

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
