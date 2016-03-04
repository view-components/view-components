<?php
namespace ViewComponents\ViewComponents\Rendering;

trait ViewTrait
{
    abstract public function render();

    final public function __toString()
    {
        return $this->render();
    }
}
