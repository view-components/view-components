<?php
namespace Presentation\Framework\Base;


use Presentation\Framework\Event\BeforeRenderTrait;

trait ComponentTrait
{
    use BeforeRenderTrait;

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
}
