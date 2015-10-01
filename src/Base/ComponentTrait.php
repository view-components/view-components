<?php
namespace Presentation\Framework\Base;


use Presentation\Framework\Event\BeforeRenderTrait;

trait ComponentTrait
{
    use BeforeRenderTrait;

    protected $componentName;

    /** @return \Nayjest\Collection\CollectionInterface */
    abstract public function children();

    public function renderChildren()
    {
        $output = '';
        /** @var ComponentInterface $child */
        foreach ($this->children() as $child) {
            $output .= $child->render();
        }
        return $output;
    }

    public function render()
    {
        return $this->beforeRender()->notify()
        . $this->renderChildren();
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
}
