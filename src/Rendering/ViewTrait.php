<?php
namespace Presentation\Framework\Rendering;


trait ViewTrait
{
    abstract public function render();

    public function __toString()
    {
        return $this->render();
    }
}
