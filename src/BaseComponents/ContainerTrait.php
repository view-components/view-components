<?php
namespace Nayjest\ViewComponents\BaseComponents;

use Nayjest\ViewComponents\Rendering\ParentViewTrait;
use Nayjest\ViewComponents\Structure\ParentTrait;

trait ContainerTrait
{
    use ParentTrait;
    use ParentViewTrait;

    abstract protected function renderOpening();

    abstract protected function renderClosing();

    public function __construct(array $components = [])
    {
        if (count($components) > 0) {
            $this->setComponents($components);
        }
    }

    public function render()
    {
        return $this->renderOpening()
        . $this->renderComponents()
        . $this->renderClosing();
    }
}
