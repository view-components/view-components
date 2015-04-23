<?php
namespace Nayjest\ViewComponents\BaseComponents;

use Nayjest\ViewComponents\Rendering\ParentViewTrait;
use Nayjest\ViewComponents\Structure\ParentTrait;

trait ContainerTrait
{
    use ParentTrait;
    use ParentViewTrait;
    use ComponentTrait;

    abstract protected function renderOpening();

    abstract protected function renderClosing();

    public function __construct(array $components = null)
    {
        if ($components !== null) {
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
