<?php
namespace Presentation\Framework\Base;

/**
 * Trait DecoratedContainerTrait.
 *
 * DecoratedContainerTrait can be used instead of ComponentTrait to provide rendering of wrapper.
 */
trait DecoratedContainerTrait
{
    use ComponentTrait {
        ComponentTrait::render as private renderInternal;
    }

    abstract protected function renderOpening();

    abstract protected function renderClosing();

    public function render()
    {
        $this->beforeRender()->notify();
        return $this->renderOpening()
        . $this->renderChildren()
        . $this->renderClosing();
    }
}
