<?php
namespace ViewComponents\ViewComponents\Rendering;

trait ViewTrait
{
    /**
     * Renders view and returns output.
     *
     * @return string output
     */
    abstract public function render();

    final public function __toString()
    {
        return $this->render();
    }
}
