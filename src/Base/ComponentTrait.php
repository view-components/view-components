<?php
namespace Presentation\Framework\Base;


trait ComponentTrait
{
    /** @return \Nayjest\Collection\CollectionInterface */
    abstract public function children();

    public function renderChildren()
    {
        $output = '';
        /** @var ComponentInterface $child */
        foreach($this->children() as $child) {
            $output .= $child->render();
        }
        return $output;
    }

    public function render()
    {
        return $this->renderChildren();
    }
}
