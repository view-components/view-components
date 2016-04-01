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

    /**
     * @return string
     */
    final public function __toString()
    {
        return $this->render();
    }
}
