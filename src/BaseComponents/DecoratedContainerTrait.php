<?php
namespace Nayjest\ViewComponents\BaseComponents;

trait DecoratedContainerTrait
{
    use ContainerTrait;

    abstract protected function renderOpening();

    abstract protected function renderClosing();

    public function render()
    {
        return $this->renderOpening()
        . $this->renderComponents()
        . $this->renderClosing();
    }
}
